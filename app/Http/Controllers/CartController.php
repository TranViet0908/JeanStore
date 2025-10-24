<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $items = $cart->items()->with('product')->get();

        $itemsForView = $items->map(function (CartItem $ci) {
            $p = $ci->product;
            $price = (int) ($ci->price ?? ($p->price ?? 0));
            $qty   = max(1, (int) ($ci->quantity ?? 1));
            return [
                'id'         => $ci->id,
                'product_id' => $ci->product_id,
                'name'       => $p->name ?? 'Sản phẩm',
                'title'      => $p->name ?? 'Sản phẩm',
                'price'      => $price,
                'quantity'   => $qty,
                'image'      => $p->image_url ?? null,
                'thumbnail'  => $p->image_url ?? null,
                'line_total' => $price * $qty,
            ];
        });

        $total = (int) $itemsForView->sum('line_total');

        // làm tươi mã theo tổng hiện tại
        $this->refreshCoupon($user->id, $total);

        // áp mã trong session
        $applied   = session('applied_coupon');
        $discount  = (int)($applied['discount'] ?? 0);
        $grandTotal = max(0, $total - $discount);

        // Gợi ý
        $productIds = $items->pluck('product_id')->filter()->values();
        $cats = Product::whereIn('id', $productIds)->pluck('category_id')->unique()->values();

        $salesSub = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id');

        $suggestedQ = Product::query()
            ->leftJoinSub($salesSub, 's', 's.product_id', '=', 'products.id')
            ->select('products.*', DB::raw('COALESCE(s.total_sold,0) as total_sold'))
            ->where('products.stock', '>', 0)
            ->whereNotIn('products.id', $productIds);

        if ($cats->isNotEmpty()) {
            $suggestedQ->whereIn('products.category_id', $cats);
        }

        $suggested = $suggestedQ
            ->orderByRaw('(COALESCE(s.total_sold,0) > 0) DESC')
            ->orderByDesc('total_sold')
            ->latest('products.created_at')
            ->limit(5)
            ->get();

        return view('cart.index', [
            'items'      => $itemsForView,
            'total'      => $total,
            'discount'   => $discount,
            'grandTotal' => $grandTotal,
            'applied'    => $applied,
            'suggested'  => $suggested,
        ]);
    }

    public function applyCoupon(Request $r)
    {
        $r->validate(['code' => 'required|string|max:64']);
        $code = strtoupper(trim($r->input('code')));
        $user = Auth::user();

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $items = $cart->items()->get();
        $total = (int) $items->sum(fn($i) => (int)$i->price * (int)$i->quantity);

        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon || !$coupon->isActiveNow()) {
            return back()->withErrors(['code' => 'Mã không hợp lệ hoặc đã hết hạn.']);
        }

        $pivot = $coupon->users()->where('users.id', $user->id)->first()?->pivot;
        if (!$pivot) {
            return back()->withErrors(['code' => 'Mã không thuộc tài khoản của bạn.']);
        }
        if ($pivot->per_user_limit && $pivot->redeemed >= $pivot->per_user_limit) {
            return back()->withErrors(['code' => 'Bạn đã dùng hết lượt của mã này.']);
        }

        $discount = (int)$coupon->computeDiscount($total);
        if ($discount <= 0) {
            return back()->withErrors(['code' => 'Giá trị đơn chưa đạt điều kiện để áp mã.']);
        }

        session([
            'applied_coupon' => [
                'code' => $coupon->code,
                'coupon_id' => $coupon->id,
                'discount' => $discount,
            ]
        ]);

        return back()->with('msg', 'Đã áp mã.');
    }

    public function removeCoupon(Request $r)
    {
        $r->session()->forget('applied_coupon');
        return back()->with('msg', 'Đã gỡ mã.');
    }

    public function add(Request $r, Product $product)
    {
        $r->validate([
            'quantity' => 'nullable|integer|min:1',
            'qty'      => 'nullable|integer|min:1',
        ]);

        $qty  = max(1, (int) ($r->input('quantity', $r->input('qty', 1))));
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = CartItem::firstOrNew([
            'cart_id'    => $cart->id,
            'product_id' => $product->id,
        ]);

        $newQty = ($item->exists ? (int)$item->quantity : 0) + $qty;
        if ($newQty > (int)$product->stock) {
            return $this->respond($r, ['ok' => false, 'msg' => 'Không đủ hàng trong kho'], 422);
        }

        $item->quantity = $newQty;
        $item->price    = (int)$product->price;
        $item->save();

        // làm tươi mã sau thay đổi giỏ
        $newTotal = (int) $cart->items()->get()->sum(fn($i) => (int)$i->price * (int)$i->quantity);
        $this->refreshCoupon($user->id, $newTotal);

        return $this->respond($r, ['ok' => true, 'msg' => 'Đã thêm sản phẩm vào giỏ']);
    }

    public function update(Request $r)
    {
        $data = $r->validate([
            'product_id' => 'required|integer|exists:products,id',
            'op'         => 'nullable|in:inc,dec,set',
            'qty'        => 'nullable|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $data['product_id'])
            ->first();

        if (!$item) {
            return $this->respond($r, ['ok' => false, 'msg' => 'Sản phẩm không có trong giỏ'], 404);
        }

        $product = Product::findOrFail($data['product_id']);

        $cur = (int) $item->quantity;
        $op  = $data['op'] ?? 'set';
        $new = $cur;

        if ($op === 'inc')       $new = $cur + 1;
        elseif ($op === 'dec')   $new = max(1, $cur - 1);
        else                     $new = max(1, (int) ($data['qty'] ?? 1));

        if ($new > (int)$product->stock) {
            return $this->respond($r, ['ok' => false, 'msg' => 'Không đủ hàng trong kho'], 422);
        }

        $item->quantity = $new;
        $item->price    = (int)$product->price;
        $item->save();

        // làm tươi mã sau thay đổi giỏ
        $newTotal = (int) $cart->items()->get()->sum(fn($i) => (int)$i->price * (int)$i->quantity);
        $this->refreshCoupon($user->id, $newTotal);

        return $this->respond($r, ['ok' => true, 'msg' => 'Đã cập nhật giỏ hàng']);
    }

    public function remove(Request $r)
    {
        $data = $r->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $deleted = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $data['product_id'])
            ->delete();

        if (!$deleted) {
            return $this->respond($r, ['ok' => false, 'msg' => 'Không tìm thấy sản phẩm trong giỏ'], 404);
        }

        // làm tươi mã sau thay đổi giỏ
        $newTotal = (int) $cart->items()->get()->sum(fn($i) => (int)$i->price * (int)$i->quantity);
        $this->refreshCoupon($user->id, $newTotal);

        return $this->respond($r, ['ok' => true, 'msg' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
    }

    public function clear(Request $r)
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->items()->delete();

        // làm tươi mã sau khi xóa hết
        $this->refreshCoupon($user->id, 0);

        return $this->respond($r, ['ok' => true, 'msg' => 'Đã xóa toàn bộ giỏ hàng']);
    }

    // ---- helpers ----
    private function respond(Request $r, array $payload, int $status = 200)
    {
        if ($r->expectsJson() || $r->wantsJson() || $r->ajax()) {
            return response()->json($payload, $status);
        }
        $msgKey = ($status >= 400) ? 'error' : 'success';
        return back()->with($msgKey, $payload['msg'] ?? null);
    }

    private function refreshCoupon($userId, int $cartTotal): void
    {
        $applied = session('applied_coupon');
        if (!$applied) return;

        $coupon = Coupon::find($applied['coupon_id']);
        if (!$coupon || !$coupon->isActiveNow()) {
            session()->forget('applied_coupon');
            return;
        }

        $pivot = $coupon->users()->where('users.id', $userId)->first()?->pivot;
        if (!$pivot || ($pivot->per_user_limit && $pivot->redeemed >= $pivot->per_user_limit)) {
            session()->forget('applied_coupon');
            return;
        }

        $discount = (int) $coupon->computeDiscount($cartTotal);
        if ($discount <= 0) {
            session()->forget('applied_coupon');
            return;
        }

        session(['applied_coupon' => [
            'code' => $coupon->code,
            'coupon_id' => $coupon->id,
            'discount' => $discount,
        ]]);
    }
}
