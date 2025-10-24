<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Cửa hàng Jeans')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        .btn-primary {
            @apply bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300;
        }

        .btn-secondary {
            @apply bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300;
        }

        .btn-danger {
            @apply bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-gradient-to-r from-indigo-950 via-slate-900 to-blue-900 text-white border-b border-slate-800/60 shadow-xl">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/15">
                        <!-- tag icon -->
                        <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h6l7 7-6 6-7-7V7zM7 7l-3 3 7 7"></path>
                        </svg>
                    </span>
                    <span class="text-xl font-bold tracking-tight">
                        Jeans <span class="text-blue-300">Store</span>
                    </span>
                </a>

                <!-- Desktop nav -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}"
                        class="px-1.5 py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'text-white border-b-2 border-white' : 'text-slate-200 hover:text-white hover:border-b-2 hover:border-white/60' }}">
                        Trang chủ
                    </a>

                    <a href="{{ route('user.products.index') }}"
                        class="px-1.5 py-2 text-sm font-medium transition {{ request()->routeIs('user.products.*') ? 'text-white border-b-2 border-white' : 'text-slate-200 hover:text-white hover:border-b-2 hover:border-white/60' }}">
                        Sản phẩm
                    </a>

                    <a href="{{ route('support.faq') }}"
                        class="px-1.5 py-2 text-sm font-medium transition {{ request()->routeIs('support.faq') ? 'text-white border-b-2 border-white' : 'text-slate-200 hover:text-white hover:border-b-2 hover:border-white/60' }}">
                        FAQ
                    </a>

                    <a href="{{ route('support.live_chat') }}"
                        class="px-1.5 py-2 text-sm font-medium transition {{ request()->routeIs('support.live_chat') ? 'text-white border-b-2 border-white' : 'text-slate-200 hover:text-white hover:border-b-2 hover:border-white/60' }}">
                        Live Chat
                    </a>

                    @auth
                    <a href="{{ route('support.tickets.index') }}"
                        class="px-1.5 py-2 text-sm font-medium transition {{ request()->routeIs('support.tickets.*') ? 'text-white border-b-2 border-white' : 'text-slate-200 hover:text-white hover:border-b-2 hover:border-white/60' }}">
                        Ticket của tôi
                    </a>

                    <a href="{{ route('user.orders.index') }}"
                        class="px-1.5 py-2 text-sm font-medium transition {{ request()->routeIs('user.orders.*') ? 'text-white border-b-2 border-white' : 'text-slate-200 hover:text-white hover:border-b-2 hover:border-white/60' }}">
                        Đơn hàng của tôi
                    </a>

                    <a href="{{ route('cart.index') }}"
                        class="text-slate-200 hover:text-white transition relative">
                        <svg class="w-6 h-6 inline align-[-2px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.5 5M9.5 18h8M9.5 18a2 2 0 11-.001 4A2 2 0 019.5 18zm8 0a2 2 0 11-.001 4A2 2 0 0117.5 18z" />
                        </svg>
                        <span class="ml-1">Giỏ hàng</span>
                    </a>

                    <!-- User menu -->
                    <div class="relative group">
                        <button class="text-slate-200 hover:text-white transition">{{ Auth::user()->full_name }}</button>
                        <div class="absolute right-0 mt-2 w-52 bg-white text-slate-800 rounded-xl shadow-xl ring-1 ring-slate-900/10 opacity-0 invisible
                                    group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-slate-50 rounded-t-xl">Tài khoản</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-slate-50 rounded-b-xl">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}"
                        class="text-slate-200 hover:text-white text-sm font-medium transition">Đăng nhập</a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center rounded-lg bg-blue-600 px-3.5 py-2 text-sm font-semibold text-white shadow hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500/60">
                        Đăng ký
                    </a>
                    @endauth
                </div>

                <!-- Mobile toggle -->
                <button id="navToggle" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-slate-200 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile nav -->
            <div id="mobileNav" class="md:hidden hidden pb-4">
                <div class="pt-2 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('home') ? 'bg-white/10 text-white' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">Trang chủ</a>
                    <a href="{{ route('user.products.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('user.products.*') ? 'bg-white/10 text-white' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">Sản phẩm</a>
                    <a href="{{ route('support.faq') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('support.faq') ? 'bg-white/10 text-white' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">FAQ</a>
                    <a href="{{ route('support.live_chat') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('support.live_chat') ? 'bg-white/10 text-white' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">Live Chat</a>

                    @auth
                    <a href="{{ route('support.tickets.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('support.tickets.*') ? 'bg-white/10 text-white' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">Ticket của tôi</a>
                    <a href="{{ route('user.orders.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('user.orders.*') ? 'bg-white/10 text-white' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">Đơn hàng của tôi</a>
                    <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-lg text-slate-200 hover:bg-white/10 hover:text-white">Giỏ hàng</a>

                    <div class="border-t border-white/10 my-2"></div>
                    <a href="#" class="block px-3 py-2 rounded-lg text-slate-200 hover:bg-white/10 hover:text-white">Tài khoản</a>
                    <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
                        @csrf
                        <button type="submit" class="w-full text-left rounded-lg px-3 py-2 text-slate-200 hover:bg-white/10 hover:text-white">Đăng xuất</button>
                    </form>
                    @else
                    <div class="border-t border-white/10 my-2"></div>
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-slate-200 hover:bg-white/10 hover:text-white">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="mt-1 inline-flex w-full justify-center rounded-lg bg-blue-600 px-3.5 py-2 text-sm font-semibold text-white shadow hover:bg-blue-500">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Jeans Store</h3>
                    <p class="text-gray-400">Cửa hàng jeans cao cấp với chất lượng tốt nhất.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên kết</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Trang chủ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Liên hệ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên hệ</h3>
                    <p class="text-gray-400">Email: info@jeansstore.com</p>
                    <p class="text-gray-400">Điện thoại: 0123 456 789</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2025 Jeans Store. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>
</body>

</html>
<script>
document.getElementById('navToggle')?.addEventListener('click', function () {
    document.getElementById('mobileNav')?.classList.toggle('hidden');
});
</script>