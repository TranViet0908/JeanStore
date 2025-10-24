<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $orders = DB::table('orders')
            ->select('id', 'total', 'status', 'payment_method', 'created_at')
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show(Request $request, $orderId)
    {
        $userId = $request->user()->id;

        $order = DB::table('orders')
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            abort(404);
        }

        $items = DB::table('order_items as oi')
            ->join('products as p', 'p.id', '=', 'oi.product_id')
            ->select('oi.id','oi.quantity','oi.price','p.name','p.image_url','oi.product_id')
            ->where('oi.order_id', $orderId)
            ->get();

        $payment = DB::table('payments')
            ->where('order_id', $orderId)
            ->orderByDesc('id')
            ->first();

        return view('user.orders.show', compact('order','items','payment'));
    }

    // Hủy đơn: chỉ khi pending. Hoàn kho các sản phẩm.
    public function cancel(Request $request, $orderId)
    {
        $userId = $request->user()->id;

        DB::beginTransaction();
        try {
            $order = DB::table('orders')
                ->where('id', $orderId)
                ->where('user_id', $userId)
                ->lockForUpdate()
                ->first();

            if (!$order) {
                DB::rollBack();
                abort(404);
            }

            if ($order->status !== 'pending') {
                DB::rollBack();
                return back()->with('error', 'Chỉ có thể hủy đơn ở trạng thái Chờ xác nhận.');
            }

            $items = DB::table('order_items')
                ->select('product_id','quantity')
                ->where('order_id', $orderId)
                ->get();

            foreach ($items as $it) {
                DB::table('products')
                    ->where('id', $it->product_id)
                    ->increment('stock', (int) $it->quantity);
            }

            DB::table('orders')
                ->where('id', $orderId)
                ->update([
                    'status' => 'cancelled',
                    'updated_at' => now(),
                ]);

            DB::commit();
            return redirect()
                ->route('user.orders.show', $orderId)
                ->with('status', 'Đã hủy đơn hàng #' . $orderId . ' và hoàn kho.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Hủy đơn thất bại. Vui lòng thử lại.');
        }
    }
}
