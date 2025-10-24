<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Coupon; // thêm
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // ... các hàm khác giữ nguyên

    public function vnpayReturn(Request $r)
    {
        // --- lấy params từ VNPAY ---
        $all        = $r->query();
        $secureHash = $all['vnp_SecureHash'] ?? '';
        $hashSecret = trim(env('VNPAY_HASH_SECRET', ''));

        // build hashData đúng chuẩn
        $data = [];
        foreach ($all as $k => $v) {
            if (str_starts_with($k, 'vnp_') && $k !== 'vnp_SecureHash' && $k !== 'vnp_SecureHashType') {
                $data[$k] = $v;
            }
        }
        ksort($data);
        $hashData = '';
        foreach ($data as $k => $v) {
            $hashData .= ($hashData ? '&' : '') . urlencode($k) . '=' . urlencode((string)$v);
        }
        $calcHash = hash_hmac('sha512', $hashData, $hashSecret);
        $sigOk    = hash_equals($calcHash, $secureHash);

        // map payment_id
        $paymentId = (int)($r->query('payment_id') ?? 0);
        if (!$paymentId && !empty($all['vnp_TxnRef']) && preg_match('/PAY-(\d+)/', $all['vnp_TxnRef'], $m)) {
            $paymentId = (int)$m[1];
        }
        $payment = $paymentId ? \App\Models\Payment::find($paymentId) : null;

        $respCode = $all['vnp_ResponseCode'] ?? null;
        $success  = $sigOk && $respCode === '00';
        $amount   = isset($all['vnp_Amount']) ? ((int)$all['vnp_Amount']) / 100 : null;
        $paidAt   = isset($all['vnp_PayDate']) ? Carbon::createFromFormat('YmdHis', $all['vnp_PayDate']) : now();

        if ($payment) {
            if ($success && $payment->status !== 'completed') {
                DB::transaction(function () use ($payment, $paidAt) {
                    // cập nhật payment
                    $payment->status   = 'completed';
                    $payment->provider = 'vnpay';
                    $payment->paid_at  = $paidAt;

                    // đồng bộ amount theo total của đơn để tránh lệch
                    $order = \App\Models\Order::lockForUpdate()->find($payment->order_id);
                    if ($order) {
                        $payment->amount = (int) round($order->total);
                    }
                    $payment->save();

                    // khóa đơn hàng, set paid, trừ tồn kho, xóa giỏ
                    if ($order) {
                        // đánh dấu đơn
                        $order->payment_method = 'online';
                        $order->status = 1; // paid (giữ nguyên kiểu hiện dùng)
                        $order->save();

                        // 1) lấy line items
                        $lines = collect();
                        try {
                            if (method_exists($order, 'items')) {
                                $lines = $order->items()->select('product_id', 'quantity', 'price')->get();
                            }
                        } catch (\Throwable $e) {}

                        if ($lines->isEmpty()) {
                            $lines = DB::table('cart_items as ci')
                                ->join('carts as c', 'ci.cart_id', '=', 'c.id')
                                ->where('c.user_id', $order->user_id)
                                ->select('ci.product_id', 'ci.quantity', 'ci.price')
                                ->get();

                            // nếu order_items chưa có thì chép từ giỏ hàng sang
                            if ($lines->isNotEmpty() && !DB::table('order_items')->where('order_id', $order->id)->exists()) {
                                DB::table('order_items')->insert(
                                    $lines->map(fn($i) => [
                                        'order_id'   => $order->id,
                                        'product_id' => (int)$i->product_id,
                                        'quantity'   => (int)$i->quantity,
                                        'price'      => (int)$i->price,
                                    ])->all()
                                );
                            }
                        }

                        // 2) gom số lượng theo sản phẩm
                        $byProduct = $lines
                            ->filter(fn($i) => (int)($i->product_id ?? 0) > 0 && (int)($i->quantity ?? 0) > 0)
                            ->groupBy(fn($i) => (int)$i->product_id)
                            ->map(fn($g) => (int)$g->sum('quantity'));

                        // 3) trừ tồn có khóa bản ghi, không âm
                        foreach ($byProduct as $pid => $qty) {
                            $p = \App\Models\Product::lockForUpdate()->find((int)$pid);
                            if (!$p) continue;
                            $dec = max(0, min((int)$qty, (int)$p->stock));
                            if ($dec > 0) {
                                $p->stock = (int)$p->stock - $dec;
                                $p->save();
                            }
                        }

                        // 4) cộng lượt dùng mã nếu đơn có mã và có giảm
                        if (!empty($order->coupon_code) && (int)$order->discount > 0) {
                            $coupon = Coupon::where('code', $order->coupon_code)->lockForUpdate()->first();
                            if ($coupon) {
                                $coupon->increment('used');
                                $coupon->users()->updateExistingPivot($order->user_id, [
                                    'redeemed' => DB::raw('redeemed + 1'),
                                ]);
                            }
                        }

                        // 5) xóa giỏ hàng của user
                        if ($cartId = DB::table('carts')->where('user_id', $order->user_id)->value('id')) {
                            DB::table('cart_items')->where('cart_id', $cartId)->delete();
                        }
                    }
                });
            } elseif (!$success && $payment->status !== 'completed') {
                $payment->status   = 'failed';
                $payment->provider = 'vnpay';
                $payment->save();
            }
        }

        return view('payments.return', [
            'status'   => $success ? 'success' : 'fail',
            'message'  => $sigOk ? (($respCode === '00') ? 'Giao dịch thành công' : ('Mã phản hồi: ' . $respCode)) : 'Sai chữ ký',
            'amount'   => $amount,
            'provider' => 'VNPAY',
            'paid_at'  => $success ? $paidAt->format('d/m/Y H:i:s') : null,
            'order_id' => $payment->order_id ?? ($r->query('order_id') ?? null),
        ]);
    }

    public function checkout(Request $r)
    {
        $order = Order::findOrFail((int)$r->get('order_id'));

        // Không tin amount từ client
        $serverAmount = (int) round($order->total); // total đã trừ discount
        $r->merge(['amount' => $serverAmount]);

        $data = $r->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'amount'   => 'nullable|integer|min:1000',
        ]);

        $order  = Order::findOrFail($data['order_id']);

        // chỉ chủ đơn hoặc admin mới được thanh toán
        $user = $r->user();
        if ($user && (($user->role ?? '') !== 'admin')) {
            abort_unless($order->user_id === $user->id, 403);
        }

        $amount = $data['amount'] ?? (int) $order->total;

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount'   => $amount,
            'provider' => 'vnpay',
            'status'   => 'pending',
        ]);

        // tạo URL thanh toán VNPAY
        $driver = new \App\Services\Drivers\VnpayDriver();
        $url    = $driver->createCheckout($payment);

        if (!$url) {
            return back()->withErrors(['payment' => 'Không tạo được URL thanh toán']);
        }
        return redirect()->away($url);
    }

    public function create(Request $r)
    {
        return $this->checkout($r);
    }
}
