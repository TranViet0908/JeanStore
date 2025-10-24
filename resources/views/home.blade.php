@extends('layouts.app')

@section('title', 'Trang Chủ - Jeans Store')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background with gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900"></div>
    <div class="absolute inset-0 bg-black opacity-30"></div>

    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-pulse animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto text-center">
            <div class="mb-8 animate-fade-in-up">
                <span class="inline-block px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-black text-sm font-semibold rounded-full mb-6 shadow-lg">
                    ✨ Bộ sưu tập mới 2025
                </span>
            </div>

            <h1 class="text-5xl md:text-7xl font-bold mb-8 text-white leading-tight animate-fade-in-up animation-delay-200">
                Bộ Sưu Tập Jeans
                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                    Cao Cấp
                </span>
            </h1>

            <p class="text-xl md:text-2xl mb-12 text-gray-200 max-w-3xl mx-auto leading-relaxed animate-fade-in-up animation-delay-400">
                Khám phá những mẫu quần jeans thời trang, chất lượng cao với thiết kế hiện đại và giá tốt nhất thị trường
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center animate-fade-in-up animation-delay-600">
                <a href="{{ route('user.products.index') }}"
                    class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-black font-bold rounded-xl text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <span class="relative z-10 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Xem Sản Phẩm
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-orange-600 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>

                <a href="#categories"
                    class="group relative inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-bold rounded-xl text-lg transition-all duration-300 hover:bg-white hover:text-slate-900 backdrop-blur-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Danh Mục
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="group text-center">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-800 mb-2 counter" data-target="1000">20+</div>
                    <div class="text-gray-600 font-medium">Sản Phẩm</div>
                </div>
            </div>

            <div class="group text-center">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-800 mb-2 counter" data-target="5000">100+</div>
                    <div class="text-gray-600 font-medium">Khách Hàng</div>
                </div>
            </div>

            <div class="group text-center">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-800 mb-2 counter" data-target="50">10+</div>
                    <div class="text-gray-600 font-medium">Thương Hiệu</div>
                </div>
            </div>

            <div class="group text-center">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-800 mb-2">99<span class="text-2xl">%</span></div>
                    <div class="text-gray-600 font-medium">Hài Lòng</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 text-sm font-semibold rounded-full mb-4">
                Sản phẩm hot
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Sản Phẩm Nổi Bật</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Những sản phẩm được yêu thích nhất với chất lượng cao và thiết kế hiện đại</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @if(isset($featuredProducts) && $featuredProducts->count() > 0)
            @foreach($featuredProducts as $product)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
                <div class="relative overflow-hidden">
                    @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-72 object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="w-full h-72 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="absolute top-4 right-4">
                        <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                            Hot
                        </span>
                    </div>

                    @if($product->stock <= 0)
                        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center backdrop-blur-sm">
                        <span class="text-white font-bold text-lg bg-red-500 px-4 py-2 rounded-lg">Hết hàng</span>
                </div>
                @endif

                <!-- Quick view overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <a href="{{ route('user.products.show', $product->id) }}" class="bg-white text-gray-800 px-4 py-2 rounded-lg font-semibold transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                        Xem nhanh
                    </a>
                </div>
            </div>

            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-blue-600 transition-colors duration-300">{{ $product->name }}</h3>
                <p class="text-gray-600 mb-4 text-sm leading-relaxed">{{ Str::limit($product->description, 80) }}</p>

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            {{ number_format($product->price, 0, ',', '.') }}đ
                        </span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Còn: {{ $product->stock }}
                    </div>
                </div>

                @auth
                @if($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="flex items-center gap-3">
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                            <button type="button" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors duration-200 quantity-btn" data-action="decrease">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 px-2 py-2 text-center border-0 focus:ring-0 quantity-input">
                            <button type="button" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors duration-200 quantity-btn" data-action="increase">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                        </svg>
                        Thêm vào giỏ
                    </button>

                    {{-- Nút xem chi tiết --}}
                    <a href="{{ route('user.products.show', $product->id) }}"
                        class="block w-full bg-white border border-gray-300 text-center text-gray-700 font-semibold py-3 px-4 rounded-xl hover:bg-gray-50 transition-all duration-300">
                        Xem chi tiết
                    </a>
                </form>
                @else
                <div class="space-y-3">
                    <button disabled class="w-full bg-gray-400 text-white font-semibold py-3 px-4 rounded-xl cursor-not-allowed">
                        Hết hàng
                    </button>
                    {{-- Nút xem chi tiết --}}
                    <a href="{{ route('user.products.show', $product->id) }}"
                        class="block w-full bg-white border border-gray-300 text-center text-gray-700 font-semibold py-3 px-4 rounded-xl hover:bg-gray-50 transition-all duration-300">
                        Xem chi tiết
                    </a>
                </div>
                @endif
                @else
                <div class="space-y-3">
                    <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-center text-black font-semibold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Đăng nhập để mua
                    </a>
                    {{-- Nút xem chi tiết --}}
                    <a href="{{ route('user.products.show', $product->id) }}"
                        class="block w-full bg-white border border-gray-300 text-center text-gray-700 font-semibold py-3 px-4 rounded-xl hover:bg-gray-50 transition-all duration-300">
                        Xem chi tiết
                    </a>
                </div>
                @endauth

            </div>
        </div>
        @endforeach
        {{-- Quantity +/− handler --}}
        <script>
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.quantity-btn');
                if (!btn) return;

                const form = btn.closest('form');
                if (!form) return;

                const input = form.querySelector('.quantity-input');
                if (!input) return;

                const min = parseInt(input.getAttribute('min')) || 1;
                const max = parseInt(input.getAttribute('max')) || Infinity;
                let val = parseInt(input.value) || min;

                if (btn.dataset.action === 'increase') val++;
                if (btn.dataset.action === 'decrease') val--;

                val = Math.max(min, Math.min(max, val));
                input.value = val;
            });

            document.addEventListener('input', function(e) {
                const input = e.target.closest('.quantity-input');
                if (!input) return;

                const min = parseInt(input.getAttribute('min')) || 1;
                const max = parseInt(input.getAttribute('max')) || Infinity;
                let val = parseInt(input.value);

                if (Number.isNaN(val)) val = min;
                val = Math.max(min, Math.min(max, val));
                input.value = val;
            });
        </script>
        @else
        <!-- Default products if no data -->
        @for($i = 1; $i <= 8; $i++)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
            <div class="relative overflow-hidden">
                <div class="w-full h-72 bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="absolute top-4 right-4">
                    <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">Hot</span>
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Quần Jeans Cao Cấp {{ $i }}</h3>
                <p class="text-gray-600 mb-4 text-sm">Chất liệu denim cao cấp, thiết kế hiện đại, phù hợp mọi dáng người</p>
                <div class="flex items-center justify-between mb-6">
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ number_format(rand(500000, 1500000), 0, ',', '.') }}đ</span>
                    <span class="text-sm text-gray-500">Còn: {{ rand(10, 50) }}</span>
                </div>

                @auth
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <input type="number" value="1" min="1" class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-center">
                    </div>
                    <button class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                        </svg>
                        Thêm vào giỏ
                    </button>
                </div>
                @else
                <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-center text-black font-semibold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105">
                    Đăng nhập để mua
                </a>
                @endauth
            </div>
    </div>
    @endfor
    @endif
    </div>

    <div class="text-center mt-12">
        <a href="{{ route('user.products.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
            Xem tất cả sản phẩm
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    </div>
    </div>
</section>

<!-- Categories Section -->
<section id="categories" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 text-sm font-semibold rounded-full mb-4">
                Danh mục sản phẩm
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Khám Phá Bộ Sưu Tập</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Tìm kiếm phong cách hoàn hảo cho bạn từ các danh mục đa dạng của chúng tôi</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(isset($categories) && $categories->count() > 0)
            @foreach($categories->take(3) as $category)
            <div class="group relative overflow-hidden rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="aspect-w-16 aspect-h-12">
                    @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-80 bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600"></div>
                    @endif
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent group-hover:from-black/80 transition-all duration-500"></div>
                <div class="absolute inset-0 flex items-end p-8">
                    <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-3xl font-bold mb-3">{{ $category->name }}</h3>
                        <p class="text-gray-200 mb-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">{{ Str::limit($category->description, 100) }}</p>
                        <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-black font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Khám phá ngay
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <!-- Default categories if no data -->
            <div class="group relative overflow-hidden rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-full h-80 bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent group-hover:from-black/80 transition-all duration-500"></div>
                <div class="absolute inset-0 flex items-end p-8">
                    <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-3xl font-bold mb-3">Jeans Nam</h3>
                        <p class="text-gray-200 mb-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">Bộ sưu tập jeans nam thời trang, hiện đại</p>
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-black font-semibold rounded-xl transition-all duration-300 transform hover:scale-105">
                            Khám phá ngay
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-full h-80 bg-gradient-to-br from-pink-400 via-purple-500 to-indigo-600"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent group-hover:from-black/80 transition-all duration-500"></div>
                <div class="absolute inset-0 flex items-end p-8">
                    <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-3xl font-bold mb-3">Jeans Nữ</h3>
                        <p class="text-gray-200 mb-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">Bộ sưu tập jeans nữ thanh lịch, quyến rũ</p>
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-black font-semibold rounded-xl transition-all duration-300 transform hover:scale-105">
                            Khám phá ngay
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-full h-80 bg-gradient-to-br from-green-400 via-teal-500 to-blue-600"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent group-hover:from-black/80 transition-all duration-500"></div>
                <div class="absolute inset-0 flex items-end p-8">
                    <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-3xl font-bold mb-3">Jeans Trẻ Em</h3>
                        <p class="text-gray-200 mb-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">Bộ sưu tập jeans trẻ em đáng yêu, thoải mái</p>
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-black font-semibold rounded-xl transition-all duration-300 transform hover:scale-105">
                            Khám phá ngay
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 text-sm font-semibold rounded-full mb-4">
                    Về chúng tôi
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Tại Sao Chọn Chúng Tôi?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Với hơn 10 năm kinh nghiệm trong ngành thời trang, chúng tôi tự hào mang đến những sản phẩm jeans chất lượng cao,
                    thiết kế hiện đại và giá cả hợp lý. Sự hài lòng của khách hàng là ưu tiên hàng đầu của chúng tôi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group text-center p-8 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Giao Hàng Nhanh</h3>
                    <p class="text-gray-600 leading-relaxed">Giao hàng toàn quốc trong 1-3 ngày làm việc với đội ngũ vận chuyển chuyên nghiệp</p>
                </div>

                <div class="group text-center p-8 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Chất Lượng Cao</h3>
                    <p class="text-gray-600 leading-relaxed">Sản phẩm chính hãng, chất lượng đảm bảo với chế độ bảo hành và đổi trả linh hoạt</p>
                </div>

                <div class="group text-center p-8 bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Hỗ Trợ 24/7</h3>
                    <p class="text-gray-600 leading-relaxed">Đội ngũ tư vấn nhiệt tình, chuyên nghiệp sẵn sàng hỗ trợ bạn mọi lúc mọi nơi</p>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center mt-16">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-12 text-white">
                    <h3 class="text-3xl font-bold mb-4">Sẵn sàng khám phá?</h3>
                    <p class="text-xl mb-8 opacity-90">Tham gia cùng hàng nghìn khách hàng hài lòng của chúng tôi</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('user.products.index') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                            Mua sắm ngay
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="#" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-blue-600 transition-all duration-300">
                            Liên hệ tư vấn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .aspect-w-16 {
        position: relative;
        padding-bottom: 75%;
    }

    .aspect-w-16>* {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
    }

    .animation-delay-400 {
        animation-delay: 0.4s;
    }

    .animation-delay-600 {
        animation-delay: 0.6s;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }

    /* Counter animation */
    .counter {
        transition: all 0.3s ease;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Custom quantity input styling */
    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .quantity-input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Counter animation
        const counters = document.querySelectorAll('.counter');
        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-target'));
            const count = parseInt(counter.innerText);
            const increment = target / 100;

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(() => animateCounter(counter), 20);
            } else {
                counter.innerText = target;
            }
        };

        // Intersection Observer for counter animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    animateCounter(counter);
                    observer.unobserve(counter);
                }
            });
        });

        counters.forEach(counter => {
            observer.observe(counter);
        });

        // Quantity buttons functionality
        document.querySelectorAll('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const input = this.parentElement.querySelector('.quantity-input');
                const currentValue = parseInt(input.value);
                const max = parseInt(input.getAttribute('max'));

                if (action === 'increase' && currentValue < max) {
                    input.value = currentValue + 1;
                } else if (action === 'decrease' && currentValue > 1) {
                    input.value = currentValue - 1;
                }
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush