<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Giữ middleware như bạn đang dùng
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * GET /orders  (giữ nguyên trả JSON cho admin hoặc API)
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'status'          => [Rule::in(['processing', 'paid', 'cancelled'])],
            'payment_method'  => [Rule::in(['COD', 'online'])],
            'user_id'         => ['nullable', 'integer'],
            'sort'            => ['nullable', 'string'],
            'per_page'        => ['nullable', 'integer', 'between:1,100'],
        ]);

        $query = Order::query()->with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $sort = $request->get('sort', '-id');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = ltrim($sort, '-');
        if (!in_array($column, ['id', 'total', 'status', 'payment_method', 'created_at'])) {
            $column = 'id';
        }
        $query->orderBy($column, $direction);

        $perPage = (int) ($request->get('per_page', 15));
        return response()->json($query->paginate($perPage));
    }

    /**
     * POST /checkout  (đặt hàng từ trang checkout)
     * - Lấy giỏ theo user đăng nhập
     * - Tính tổng từ DB (không tin client)
     * - Tạo order và (tuỳ) copy order_items
     * - Nếu request JSON -> trả JSON; nếu form web -> redirect success
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_method'   => ['required', Rule::in(['COD', 'online'])],
            'shipping_name'    => ['required', 'string', 'max:255'],
            'shipping_phone'   => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city'    => ['required', 'string', 'max:120'],
            'shipping_zip'     => ['nullable', 'string', 'max:20'],
        ]);

        $userId = auth()->id();

        // Lấy giỏ + items từ DB theo user
        $cart = Cart::with('items')->firstOrCreate(['user_id' => $userId]);

        $subtotal = $cart->items->sum(fn($i) => $i->price * $i->quantity);
        if ($subtotal <= 0) {
            // Web flow: quay lại checkout kèm lỗi; API: trả 422
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Giỏ hàng đang trống.'], 422);
            }
            return back()->with('error', 'Giỏ hàng đang trống.');
        }

        $shipping = 0; // sau này gắn logic phí ship thật cũng được
        $grand    = $subtotal + $shipping;

        $order = DB::transaction(function () use ($data, $userId, $grand, $cart) {
            // Tạo đơn
            $order = Order::create([
                'user_id'         => $userId,
                'total'           => $grand,
                'status'          => 'processing',
                'payment_method'  => $data['payment_method'],
                'shipping_name'   => $data['shipping_name'],
                'shipping_phone'  => $data['shipping_phone'],
                'shipping_address' => $data['shipping_address'],
                'shipping_city'   => $data['shipping_city'],
                'shipping_zip'    => $data['shipping_zip'] ?? null,
            ]);

            // Nếu bạn có quan hệ $order->items() và bảng order_items, copy chi tiết từ cart sang
            if (method_exists($order, 'items')) {
                foreach ($cart->items as $ci) {
                    $order->items()->create([
                        'product_id' => $ci->product_id,
                        'quantity'   => $ci->quantity,
                        'price'      => $ci->price,
                    ]);
                }
            }

            // Xoá giỏ sau khi tạo đơn
            $cart->items()->delete();

            return $order;
        });

        // Tùy theo loại request, trả về phù hợp
        if ($request->wantsJson()) {
            return response()->json($order->load('user'), 201);
        }

        return redirect()->route('order.success', $order);
    }

    /**
     * GET /orders/{order}
     */
    public function show(Order $order)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if (($user->role ?? null) !== 'admin' && $order->user_id !== $user->id) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        }

        return response()->json($order->load('user'));
    }

    /**
     * PUT/PATCH /orders/{order}
     */
    public function update(Request $request, Order $order)
    {
        $user = auth()->user();
        if (($user->role ?? null) !== 'admin' && $order->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'status'         => ['sometimes', Rule::in(['processing', 'paid', 'cancelled'])],
            'payment_method' => ['sometimes', Rule::in(['COD', 'online'])],
            // total không cho client chỉnh trong web flow; nếu cần cho admin:
            'total'          => ['sometimes', 'numeric', 'min:0'],
        ]);

        $order->update($data);

        return response()->json($order->fresh()->load('user'));
    }

    /**
     * DELETE /orders/{order}
     */
    public function destroy(Order $order)
    {
        $user = auth()->user();
        if (($user->role ?? null) !== 'admin' && $order->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $order->delete();
        return response()->json([], 204);
    }
    public function detail(int $id)
    {
        $order = Order::findOrFail($id);
        return view('order.detail', compact('order'));
    }
    public function createFromCart(Request $r)
    {
        // Lấy tổng tiền từ form; fallback từ session nếu thiếu
        $total = (int) $r->input('total', 0);
        if ($total <= 0) {
            $cart = session('cart', []);
            if (!empty($cart)) {
                $total = collect($cart)->sum(function ($i) {
                    $price = (int) ($i['price'] ?? 0);
                    $qty   = (int) ($i['quantity'] ?? ($i['qty'] ?? 1));
                    return $price * $qty;
                });
            }
        }

        if ($total <= 0) {
            abort(400, 'Giỏ hàng trống');
        }

        // CHỈNH TÊN CỘT: dùng 'total' đúng với bảng orders
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'total'   => $total,        // <-- sửa từ total_amount -> total
            'status'  => 'pending',
            // 'payment_method' => 'COD', // bật dòng này nếu cột không có default
        ]);

        session(['pending_order_id' => $order->id]);

        return redirect()->to("/payments/checkout?order_id={$order->id}&amount={$total}");
    }
}
