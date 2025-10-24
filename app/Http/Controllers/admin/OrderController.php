<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    private function hasCol(string $col): bool
    {
        return Schema::hasColumn('orders', $col);
    }

    public function index(Request $r)
    {
        $q = Order::query()->with('user');

        // Tìm kiếm linh hoạt: id, order_number, customer_email, user email/name
        if ($s = trim((string)$r->get('q'))) {
            $q->where(function ($x) use ($s) {
                if (ctype_digit($s)) {
                    $x->orWhere('id', (int)$s);
                }
                if ($this->hasCol('order_number')) {
                    $x->orWhere('order_number', 'like', "%{$s}%");
                }
                if ($this->hasCol('customer_email')) {
                    $x->orWhere('customer_email', 'like', "%{$s}%");
                }
            })->orWhereHas('user', function ($u) use ($s) {
                $u->where('email', 'like', "%{$s}%")
                    ->orWhere('full_name', 'like', "%{$s}%")
                    ->orWhere('name', 'like', "%{$s}%");
            });
        }

        // Lọc trạng thái, phương thức thanh toán
        if ($st = $r->get('status')) {
            $q->where('status', $st);
        }
        if ($pm = $r->get('payment')) {
            $q->where('payment_method', $pm);
        }

        // Lọc theo ngày tạo (YYYY-MM-DD)
        $from = $r->get('from');
        $to = $r->get('to');
        if ($this->hasCol('created_at')) {
            if ($from) {
                $q->whereDate('created_at', '>=', $from);
            }
            if ($to) {
                $q->whereDate('created_at', '<=', $to);
            }
        }

        // Sắp xếp: mặc định mới nhất
        $q->when($this->hasCol('created_at'), fn($qq) => $qq->latest('created_at'))
            ->when(!$this->hasCol('created_at'), fn($qq) => $qq->orderByDesc('id'));

        $orders = $q->paginate(20)->appends($r->query());

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Eager user + items nếu có, fallback DB join nếu không có quan hệ
        $order->loadMissing('user');
        $items = collect();
        if (method_exists($order, 'items')) {
            try {
                $items = $order->items()->with('product')->get();
            } catch (\Throwable $e) {
            }
        }
        if ($items->isEmpty()) {
            $items = DB::table('order_items as oi')
                ->where('oi.order_id', $order->id)
                ->leftJoin('products as p', 'p.id', '=', 'oi.product_id')
                ->select('oi.*', DB::raw('p.name as product_name'), DB::raw('p.image_url as product_image'))
                ->get();
        }
        return view('admin.orders.show', compact('order', 'items'));
    }

    public function edit(Order $order)
    {
        $order->loadMissing('user');
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $r, Order $order)
    {
        // Khớp với các option trên form + các trạng thái bổ sung
        $allowed = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'paid', 'completed', 'failed', 'refunded'];

        $data = $r->validate([
            'status' => ['required', Rule::in($allowed)],
        ]);

        // Chuẩn hóa chính tả nếu gửi 'canceled'
        if (($data['status'] ?? null) === 'canceled') {
            $data['status'] = 'cancelled';
        }

        $order->update($data);
        return back()->with('success', 'Đã cập nhật trạng thái');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Đã xóa đơn');
    }
}
