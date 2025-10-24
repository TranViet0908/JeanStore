@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    {{-- Stats Cards --}}
    <div class="row mb-4">
        {{-- Total Products --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow h-100 py-2 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col me-2">
                            <div class="small fw-bold text-primary text-uppercase mb-1">Tổng sản phẩm</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $stats['total_products'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Categories --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow h-100 py-2 border-start border-4 border-success">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col me-2">
                            <div class="small fw-bold text-success text-uppercase mb-1">Danh mục</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $stats['total_categories'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Users --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow h-100 py-2 border-start border-4 border-info">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col me-2">
                            <div class="small fw-bold text-info text-uppercase mb-1">Người dùng</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $stats['total_users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow h-100 py-2 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col me-2">
                            <div class="small fw-bold text-warning text-uppercase mb-1">Đơn hàng</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $stats['total_orders'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Cards --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-success">Doanh thu hôm nay</h5>
                    <h3 class="text-success">{{ number_format($stats['revenue_today']) }}đ</h3>
                    <small class="text-muted">+12% so với hôm qua</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary">Doanh thu tháng này</h5>
                    <h3 class="text-primary">{{ number_format($stats['revenue_month']) }}đ</h3>
                    <small class="text-muted">+8% so với tháng trước</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-danger">Sản phẩm sắp hết</h5>
                    <h3 class="text-danger">{{ $stats['low_stock_products'] }}</h3>
                    <small class="text-muted">Cần nhập thêm hàng</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Analytics Charts --}}
    <div class="row mb-4">
        <div class="col-lg-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header"><strong>Trạng thái đơn hàng</strong></div>
                <div class="card-body"><canvas id="chartOrdersStatus" height="150"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header"><strong>Doanh thu theo tháng ({{ now()->year }})</strong></div>
                <div class="card-body"><canvas id="chartRevenueMonthly" height="150"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header"><strong>Top 5 sản phẩm theo doanh thu</strong></div>
                <div class="card-body"><canvas id="chartTopProducts" height="150"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header"><strong>Phương thức thanh toán</strong></div>
                <div class="card-body"><canvas id="chartPaymentMethods" height="150"></canvas></div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js + init --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script id="charts-data" type="application/json">
{!! json_encode($charts ?? new \stdClass(), JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) !!}
</script>

<script>
// @ts-nocheck
(function () {
    const raw = document.getElementById('charts-data')?.textContent || '{}';
    const CHARTS = JSON.parse(raw);
    const toVND = v => (v || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + 'đ';
    const palette = n => Array.from({ length: n }, (_, i) => `hsl(${(i * 67) % 360} 70% 55%)`);

    // 1) Revenue 7d
    (function () {
        const el = document.getElementById('chartRevenue7d');
        if (!el) return;
        const d = CHARTS.revenue_7d ?? { labels: [], data: [] };
        new Chart(el, {
            type: 'line',
            data: { labels: d.labels, datasets: [{ label: 'Doanh thu', data: d.data, tension: .35, fill: false }] },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { ticks: { callback: v => toVND(v) } } }
            }
        });
    })();

    // 2) Orders status
    (function () {
        const el = document.getElementById('chartOrdersStatus');
        if (!el) return;
        const d = CHARTS.orders_status ?? { labels: [], data: [] };
        new Chart(el, {
            type: 'doughnut',
            data: { labels: d.labels, datasets: [{ data: d.data, backgroundColor: palette(d.labels.length) }] },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
    })();

    // 3) Revenue monthly
    (function () {
        const el = document.getElementById('chartRevenueMonthly');
        if (!el) return;
        const d = CHARTS.revenue_monthly ?? { labels: [], data: [] };
        new Chart(el, {
            type: 'bar',
            data: { labels: d.labels, datasets: [{ label: 'Doanh thu', data: d.data }] },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { ticks: { callback: v => toVND(v) } } }
            }
        });
    })();

    // 4) Top products
    (function () {
        const el = document.getElementById('chartTopProducts');
        if (!el) return;
        const d = CHARTS.top_products ?? { labels: [], data: [] };
        new Chart(el, {
            type: 'bar',
            data: { labels: d.labels, datasets: [{ label: 'Doanh thu', data: d.data }] },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { ticks: { callback: v => toVND(v) } } }
            }
        });
    })();

    // 5) Payment methods
    (function () {
        const el = document.getElementById('chartPaymentMethods');
        if (!el) return;
        const d = CHARTS.payment_methods ?? { labels: [], data: [] };
        new Chart(el, {
            type: 'pie',
            data: { labels: d.labels, datasets: [{ data: d.data, backgroundColor: palette(d.labels.length) }] },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
    })();
})();
</script>
@endsection
