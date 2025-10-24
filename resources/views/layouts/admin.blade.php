<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - BanQuanJeans')</title>
    <!-- Sử dụng Bootstrap thay vì Tailwind để tránh lỗi compilation -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #1f2937;
            min-height: 100vh;
            width: 250px;
        }

        .sidebar a {
            color: #d1d5db;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #374151;
            color: white;
            border-right: 4px solid #3b82f6;
        }

        .main-content {
            flex: 1;
            background-color: #f8f9fa;
        }

        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Logo -->
            <div class="p-3 border-bottom border-secondary">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tshirt me-2"></i>
                    BanQuanJeans
                </a>
                <small class="text-muted d-block">Admin Panel</small>
            </div>

            {{-- Sidebar Navigation – Denim dark + light highlight --}}
            @php
            $nav = [
            ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'tachometer-alt', 'label' => 'Dashboard'],

            // Quản trị nội dung
            ['route' => 'admin.categories.index', 'match' => 'admin.categories.*', 'icon' => 'list', 'label' => 'Danh mục'],
            ['route' => 'admin.products.index', 'match' => 'admin.products.*', 'icon' => 'shopping-bag', 'label' => 'Sản phẩm'],
            ['route' => 'admin.users.index', 'match' => 'admin.users.*', 'icon' => 'users', 'label' => 'Người dùng'],
            ['route' => 'admin.orders.index', 'match' => 'admin.orders.*', 'icon' => 'shopping-cart', 'label' => 'Đơn hàng'],

            // Bán hàng
            ['route' => 'admin.payments.index', 'match' => 'admin.payments.*', 'icon' => 'credit-card', 'label' => 'Thanh toán'],
            ['route' => 'admin.coupons.index', 'match' => 'admin.coupons.*', 'icon' => 'percent', 'label' => 'Mã giảm giá'],

            // Support
            ['route' => 'admin.reviews.index', 'match' => 'admin.reviews.*', 'icon' => 'star', 'label' => 'Đánh giá'],
            ['route' => 'admin.faqs.index', 'match' => 'admin.faqs.*', 'icon' => 'circle-question', 'label' => 'FAQ'],
            ['route' => 'admin.tickets.index', 'match' => 'admin.tickets.*', 'icon' => 'life-ring', 'label' => 'Tickets'],
            ['route' => 'admin.livechats.index', 'match' => 'admin.livechats.*', 'icon' => 'comments', 'label' => 'Live Chat'],
            ];
            @endphp

            <nav class="mt-3 sidebar theme-denim-dark">
                <div class="px-3 mb-2">
                    <small class="menu-head text-uppercase">Menu chính</small>
                </div>

                <ul class="nav nav-pills flex-column gap-1 px-2">
                    @foreach ($nav as $it)
                    @php $active = request()->routeIs($it['match']); @endphp
                    <li class="nav-item">
                        <a href="{{ route($it['route']) }}"
                            class="nav-link d-flex align-items-center {{ $active ? 'active' : '' }}"
                            @if($active) aria-current="page" @endif>
                            <i class="fas fa-{{ $it['icon'] }} me-2"></i>
                            <span>{{ $it['label'] }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </nav>

            @push('styles')
            <style>
                /* ===== Denim variables ===== */
                .theme-denim-dark {
                    --denim-bg-deep: #0a1b2e;
                    /* nền rất tối (navy) */
                    --denim-bg-mid: #173457;
                    /* chuyển sắc denim */
                    --denim-ink: #e7eef8;
                    /* chữ sáng */
                    --denim-muted: #9eb6d1;
                    /* phụ */
                    --denim-stitch: #d9b45b;
                    /* chỉ vàng */
                    --denim-hl: #3a6ea5;
                    /* highlight denim nhạt */
                    --denim-hl-2: #5b8ec7;
                    /* highlight sáng hơn */
                    background:
                        radial-gradient(120% 100% at 0% 0%, rgba(255, 255, 255, .06) 0%, transparent 55%),
                        radial-gradient(140% 120% at 100% 100%, rgba(255, 255, 255, .05) 0%, transparent 60%),
                        linear-gradient(145deg, var(--denim-bg-deep) 0%, var(--denim-bg-mid) 60%, var(--denim-bg-deep) 100%);
                    color: var(--denim-ink);
                    border-radius: 16px;
                    position: relative;
                    padding-bottom: 8px;
                    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .06);
                }

                /* đường chỉ may */
                .theme-denim-dark::before {
                    content: "";
                    position: absolute;
                    inset: 6px;
                    border: 2px dashed color-mix(in oklab, var(--denim-stitch) 60%, transparent);
                    border-radius: 12px;
                    pointer-events: none;
                }

                .theme-denim-dark .menu-head {
                    color: var(--denim-muted);
                    letter-spacing: .06em
                }

                .theme-denim-dark .nav-link {
                    color: var(--denim-ink);
                    border-radius: 12px;
                    padding: .55rem .75rem;
                    background: transparent;
                    transition: background .15s ease, transform .06s ease, color .15s ease;
                }

                .theme-denim-dark .nav-link i {
                    opacity: .9
                }

                /* hover: highlight nhạt hơn nền */
                .theme-denim-dark .nav-link:hover {
                    background: linear-gradient(90deg,
                            color-mix(in oklab, var(--denim-hl) 22%, transparent),
                            color-mix(in oklab, var(--denim-hl-2) 22%, transparent));
                    transform: translateX(1px);
                }

                /* active: highlight rõ, vẫn denim và sáng hơn nền */
                .theme-denim-dark .nav-link.active {
                    background: linear-gradient(90deg, var(--denim-hl) 0%, var(--denim-hl-2) 100%);
                    color: #fff;
                    font-weight: 600;
                    box-shadow: inset 3px 0 0 0 var(--denim-stitch);
                }

                .theme-denim-dark .nav-link.active i {
                    opacity: 1
                }
            </style>
            @endpush

        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="bg-white border-bottom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">@yield('page-title', 'Dashboard')</h1>

                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>
                            {{ Auth::user()->full_name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <h6 class="dropdown-header">{{ Auth::user()->email }}</h6>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Cài đặt</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-4">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Thêm Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>