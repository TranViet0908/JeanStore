@extends('home')

@section('title', $product->name)

@section('content')
@php
$avg = round((float)($product->reviews()->avg('rating') ?? 0), 1);
$count = (int) $product->reviews()->count();
$reviews = $product->reviews()->with('user')->latest()->take(10)->get();

$prev = url()->previous();
$backUrl = $prev ?: route('user.products.index');
@endphp

<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-4">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('user.products.index') }}" class="hover:underline">Sản phẩm</a>
            <span class="mx-2">/</span>
            <span>{{ $product->name }}</span>
        </nav>

        <a href="{{ $backUrl }}" class="inline-flex items-center gap-2 border rounded-lg px-4 py-2 hover:bg-gray-50">
            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 111.414 1.414L7.414 9H17a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" />
            </svg>
            Quay lại
        </a>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Ảnh --}}
        <div class="aspect-square bg-gray-100 flex items-center justify-center rounded-xl overflow-hidden">
            @php
            $src = '';
            if (!empty($product->image_url)) {
            $src = preg_match('/^https?:\/\//', $product->image_url) ? $product->image_url : asset($product->image_url);
            }
            @endphp
            @if($src)
            <img src="{{ $src }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
            <span class="text-gray-400 text-sm">No Image</span>
            @endif
        </div>

        {{-- Thông tin --}}
        <div>
            <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
            <div class="text-xl font-semibold text-gray-900 mb-1">
                {{ number_format((int)($product->price ?? 0), 0, ',', '.') }}₫
            </div>
            <div class="text-sm text-gray-600 mb-2">Tồn kho: {{ (int)($product->stock ?? 0) }}</div>

            {{-- Điểm trung bình sao --}}
            <div class="flex items-center gap-2 mb-4">
                <div class="flex">
                    @for($i=1;$i<=5;$i++)
                        <svg class="w-5 h-5 {{ $i <= floor($avg) ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.036a1 1 0 00-1.175 0l-2.802 2.036c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.88 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        @endfor
                </div>
                <span class="text-sm text-gray-700">{{ $avg }} / 5 · {{ $count }} đánh giá</span>
            </div>

            {{-- Mô tả chi tiết --}}
            <div class="prose max-w-none mb-6">
                <h2 class="text-lg font-semibold mb-2">Mô tả chi tiết</h2>
                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
            </div>

            @auth
            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex items-center gap-3">
                @csrf
                <input type="number" name="quantity" value="1" min="1" class="w-24 border rounded-lg px-3 py-2">
                <button type="submit" class="bg-black text-white px-5 py-2 rounded-lg hover:bg-gray-900">Thêm vào giỏ</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="inline-block bg-black text-white px-5 py-2 rounded-lg hover:bg-gray-900">Đăng nhập để mua</a>
            @endauth

            <div class="mt-6">
                <a href="{{ route('user.products.index', ['category_id' => $product->category_id]) }}"
                    class="inline-flex items-center border rounded-lg px-4 py-2 hover:bg-gray-50">Xem thêm cùng danh mục</a>
            </div>
        </div>
    </div>

    {{-- ĐÁNH GIÁ & BÌNH LUẬN --}}
    <div class="mt-10 border-t pt-6">
        <h2 class="text-xl font-semibold mb-4">Đánh giá & bình luận</h2>

        @auth
        <form action="{{ route('reviews.store', $product) }}" method="POST" class="mb-6 space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Chấm sao</label>
                <select name="rating" class="border rounded-lg px-3 py-2">
                    @for($i=5;$i>=1;$i--)
                    <option value="{{ $i }}">{{ $i }} sao</option>
                    @endfor
                </select>
                @error('rating')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Nhận xét</label>
                <textarea name="content" rows="3" class="w-full border rounded-lg px-3 py-2" placeholder="Cảm nhận của bạn..."></textarea>
                @error('content')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <button class="bg-black text-white px-4 py-2 rounded-lg">Gửi đánh giá</button>
        </form>
        @else
        <p class="text-sm text-gray-600 mb-4">Đăng nhập để viết đánh giá.</p>
        @endauth

        <div class="space-y-5">
            @forelse($reviews as $rv)
            <div class="border rounded-xl p-4">
                <div class="flex items-center justify-between mb-1">
                    <div class="font-medium">
                        {{ optional($rv->user)->full_name ?? optional($rv->user)->name ?? 'Người dùng' }}
                    </div>

                    <div class="flex">
                        @for($i=1;$i<=5;$i++)
                            <svg class="w-4 h-4 {{ $i <= $rv->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.036a1 1 0 00-1.175 0l-2.802 2.036c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.88 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                    </div>
                </div>
                <p class="text-gray-700">{{ $rv->content }}</p>
                <div class="text-xs text-gray-500 mt-1">{{ $rv->created_at->format('d/m/Y H:i') }}</div>
            </div>
            @empty
            <p class="text-sm text-gray-600">Chưa có đánh giá.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection