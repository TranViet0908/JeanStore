<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class ProductController extends Controller
{
    // Ưu tiên: best-seller → cùng category → đã xem (DB) → sắp hết kho → còn lại
    public function index(Request $request)
    {
        $catId     = (int) $request->input('category_id', 0);
        $q         = trim((string) $request->input('q', ''));
        $threshold = 5;

        // Tổng số lượng bán ra
        $salesSub = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id');

        // Sản phẩm user đã xem
        if (Auth::check()) {
            $pvSub = DB::table('product_views')
                ->select('product_id',
                         DB::raw('MAX(last_viewed_at) as last_viewed_at'),
                         DB::raw('SUM(views_count) as views_sum'))
                ->where('user_id', Auth::id())
                ->groupBy('product_id');
        } else {
            $pvSub = DB::table('product_views')
                ->select('product_id',
                         DB::raw('MAX(last_viewed_at) as last_viewed_at'),
                         DB::raw('SUM(views_count) as views_sum'))
                ->where('session_id', $request->session()->getId())
                ->groupBy('product_id');
        }

        // Builder chính
        $query = Product::query()
            ->leftJoinSub($salesSub, 's', 's.product_id', '=', 'products.id')
            ->leftJoinSub($pvSub,   'pv','pv.product_id', '=', 'products.id')
            ->when($q !== '', fn($qb) => $qb->where('products.name', 'like', "%{$q}%"))
            ->when($catId > 0, fn($qb) => $qb->where('products.category_id', $catId))
            ->select(
                'products.*',
                DB::raw('COALESCE(s.total_sold,0) as total_sold'),
                DB::raw('COALESCE(pv.views_sum,0) as views_sum'),
                DB::raw('pv.last_viewed_at as last_viewed_at')
            )
            // 1) bán chạy
            ->orderByRaw('(COALESCE(s.total_sold,0) > 0) DESC')
            ->orderByRaw('COALESCE(s.total_sold,0) DESC')
            // 2) cùng category (giữ ưu tiên khi đang xem all)
            ->orderByRaw('(CASE WHEN ? > 0 AND products.category_id = ? THEN 1 ELSE 0 END) DESC', [$catId, $catId])
            // 3) đã xem
            ->orderByRaw('(COALESCE(pv.views_sum,0) > 0) DESC')
            ->orderByRaw('COALESCE(pv.last_viewed_at, "1970-01-01") DESC')
            // 4) sắp hết kho
            ->orderByRaw('(COALESCE(products.stock,0) <= ?) DESC', [$threshold])
            // 5) mới tạo
            ->orderBy('products.created_at', 'DESC');

        $products   = $query->paginate(20)->withQueryString();
        $categories = Category::select('id', 'name')->orderBy('name')->get();

        return view('user.products.index', [
            'products'   => $products,
            'categoryId' => $catId,
            'q'          => $q,
            'threshold'  => $threshold,
            'categories' => $categories,
        ]);
    }

    // Ghi nhận lượt xem
    public function show(Product $product, Request $request)
    {
        $match = Auth::check()
            ? ['user_id' => Auth::id(), 'product_id' => $product->id]
            : ['session_id' => $request->session()->getId(), 'product_id' => $product->id];

        $now = now();
        $existing = DB::table('product_views')->where($match)->first();

        if ($existing) {
            DB::table('product_views')->where('id', $existing->id)->update([
                'views_count'    => DB::raw('views_count + 1'),
                'last_viewed_at' => $now,
                'updated_at'     => $now,
            ]);
        } else {
            DB::table('product_views')->insert($match + [
                'views_count'    => 1,
                'last_viewed_at' => $now,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }

        return view('user.products.show', compact('product'));
    }
}
