<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private function moneyColumn(): ?string
    {
        return collect(['grand_total', 'total', 'total_amount', 'amount', 'total_price'])
            ->first(fn($c) => Schema::hasColumn('orders', $c));
    }

    private function hasCol(string $table, string $col): bool
    {
        return Schema::hasColumn($table, $col);
    }

    public function index()
    {
        $col = $this->moneyColumn();

        // ===== Stats gốc (giữ nguyên hành vi)
        $revenueToday = $col ? Order::whereDate('created_at', now())->sum($col) : 0;
        $revenueMonth = $col ? Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum($col) : 0;

        $stats = [
            'total_products'     => Product::count(),
            'total_categories'   => Category::count(),
            'total_users'        => User::count(),
            'total_orders'       => Order::count(),
            'revenue_today'      => $revenueToday,
            'revenue_month'      => $revenueMonth,
            'low_stock_products' => Product::where('stock', '<=', 5)->count(),
            'recent_products'    => Product::latest()->take(5)->get(),
        ];

        // ===== Scope cho "đơn đã hoàn tất" nếu có cột status
        $completedStatuses = ['paid', 'completed', 'success', 'delivered', 'shipped'];
        $completedOrders = Order::query();
        if ($this->hasCol('orders', 'status')) {
            $completedOrders->whereIn('status', $completedStatuses);
        }

        // ===== 1) Doanh thu 7 ngày
        $days = collect(range(6, 0))->map(fn($i) => Carbon::today()->subDays($i));
        $charts['revenue_7d'] = [
            'labels' => $days->map->format('d/m')->all(),
            'data'   => $days->map(function ($d) use ($col, $completedOrders) {
                if (!$col) return 0;
                return (clone $completedOrders)->whereDate('created_at', $d)->sum($col);
            })->map(fn($v) => (int)$v)->all(),
        ];

        // ===== 2) Trạng thái đơn
        if ($this->hasCol('orders', 'status')) {
            $statusList = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'paid', 'completed', 'success'];
            $charts['orders_status'] = [
                'labels' => $statusList,
                'data'   => array_map(fn($s) => Order::where('status', $s)->count(), $statusList),
            ];
        } else {
            $charts['orders_status'] = [
                'labels' => ['all'],
                'data'   => [Order::count()],
            ];
        }

        // ===== 3) Doanh thu theo tháng (năm hiện tại)
        $year = now()->year;
        $labels = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        if ($col) {
            $raw = Order::selectRaw('MONTH(created_at) as m, SUM(' . $col . ') as s')
                ->whereYear('created_at', $year)
                ->groupBy('m')
                ->pluck('s', 'm'); // [m => sum]
            $data = [];
            for ($m = 1; $m <= 12; $m++) {
                $data[] = (int) round((float) ($raw[$m] ?? 0));
            }
        } else {
            $data = array_fill(0, 12, 0);
        }

        $charts['revenue_monthly'] = [
            'labels' => $labels,
            'data'   => $data,
        ];

        // ===== 4) Top 5 sản phẩm theo doanh thu
        $charts['top_products'] = ['labels' => [], 'data' => []];
        if (Schema::hasTable('order_items')) {
            // cố gắng suy luận cột
            $qtyCol   = Schema::hasColumn('order_items', 'quantity') ? 'quantity' : (Schema::hasColumn('order_items', 'qty') ? 'qty' : null);
            $priceCol = Schema::hasColumn('order_items', 'price') ? 'price' : (Schema::hasColumn('order_items', 'unit_price') ? 'unit_price' : null);
            $subCol   = Schema::hasColumn('order_items', 'subtotal') ? 'subtotal' : null;

            $items = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id');

            if ($this->hasCol('orders', 'status')) {
                $items->whereIn('orders.status', $completedStatuses);
            }

            if ($subCol) {
                $items->select('products.name', DB::raw("SUM(order_items.$subCol) AS revenue"));
            } elseif ($qtyCol && $priceCol) {
                $items->select('products.name', DB::raw("SUM(order_items.$qtyCol * order_items.$priceCol) AS revenue"));
            } else {
                // fallback: đếm số lượng bán
                $c = $qtyCol ?: 'id';
                $items->select('products.name', DB::raw("SUM(order_items.$c) AS revenue"));
            }

            $top = $items->groupBy('products.name')->orderByDesc('revenue')->limit(5)->get();
            $charts['top_products'] = [
                'labels' => $top->pluck('name')->all(),
                'data'   => $top->pluck('revenue')->map(fn($v) => (int)$v)->all(),
            ];
        } else {
            // fallback: sản phẩm tồn kho thấp nhất
            $fallback = Product::orderBy('stock', 'asc')->limit(5)->get(['name', 'stock']);
            $charts['top_products'] = [
                'labels' => $fallback->pluck('name')->all(),
                'data'   => $fallback->pluck('stock')->all(),
            ];
        }

        // ===== 5) Phương thức thanh toán
        if ($this->hasCol('orders', 'payment_method')) {
            $rows = Order::query()
                ->when($this->hasCol('orders', 'status'), fn($q) => $q->whereIn('status', $completedStatuses))
                ->select('payment_method', DB::raw('COUNT(*) AS c'))
                ->groupBy('payment_method')->get();

            $charts['payment_methods'] = [
                'labels' => $rows->pluck('payment_method')->map(fn($m) => strtoupper((string)$m))->all(),
                'data'   => $rows->pluck('c')->all(),
            ];
        } else {
            $charts['payment_methods'] = ['labels' => [], 'data' => []];
        }

        return view('admin.dashboard', compact('stats', 'charts'));
    }
}
