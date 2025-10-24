<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\ProductView;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $userId    = optional($request->user())->id;
        $sessionId = $request->session()->getId();
        $sort      = $request->get('sort');

        $query = Product::query()
            ->select('products.*')
            ->with('category')
            ->where('products.stock', '>', 0)
            // cột phụ pv_last_viewed_at cho user đang đăng nhập hoặc theo session khách
            ->selectSub(function ($q) use ($userId, $sessionId) {
                $q->from('product_views')
                    ->select('last_viewed_at')
                    ->whereColumn('product_views.product_id', 'products.id')
                    ->when($userId, fn($qq) => $qq->where('user_id', $userId))
                    ->unless($userId, fn($qq) => $qq->where('session_id', $sessionId))
                    ->orderByDesc('last_viewed_at')
                    ->limit(1);
            }, 'pv_last_viewed_at');

        // Filter
        if ($request->filled('category')) {
            $query->where('products.category_id', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('products.name', 'like', '%' . $request->search . '%');
        }

        // Ưu tiên: đã xem trước, mới xem trước
        $query->orderByRaw('CASE WHEN pv_last_viewed_at IS NULL THEN 1 ELSE 0 END ASC')
            ->orderByDesc('pv_last_viewed_at');

        // Thêm sort phụ nếu có
        if ($sort === 'price_asc') {
            $query->orderBy('products.price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('products.price', 'desc');
        } else {
            $query->orderByDesc('products.created_at');
        }

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product, Request $request)
    {
        // ghi nhận đã xem cho user hoặc khách theo session
        $identity = $request->user()
            ? ['user_id' => $request->user()->id, 'product_id' => $product->id]
            : ['session_id' => $request->session()->getId(), 'product_id' => $product->id];

        $pv = ProductView::firstOrCreate($identity, ['views_count' => 0]);
        $pv->increment('views_count');
        $pv->last_viewed_at = now();
        // nếu vừa đăng nhập, lưu cả session để tham chiếu chéo
        if (isset($identity['user_id'])) $pv->session_id = $request->session()->getId();
        $pv->save();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
