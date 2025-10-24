@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('user.orders.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Quay lại danh sách
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Đơn hàng #{{ $order->id }}</h1>
                        <p class="text-gray-600 mt-1">Chi tiết thông tin đơn hàng của bạn</p>
                    </div>
                </div>

                <!-- Order Status Badge -->
                <div class="hidden sm:block">
                    @php
                    $statusConfig = [
                    'pending' => [
                    'bg' => 'bg-gradient-to-r from-amber-100 to-yellow-100',
                    'text' => 'text-amber-800',
                    'ring' => 'ring-amber-200',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                    'label' => 'Chờ xác nhận'
                    ],
                    'processing' => [
                    'bg' => 'bg-gradient-to-r from-blue-100 to-indigo-100',
                    'text' => 'text-blue-800',
                    'ring' => 'ring-blue-200',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>',
                    'label' => 'Đang xử lý'
                    ],
                    'shipped' => [
                    'bg' => 'bg-gradient-to-r from-purple-100 to-indigo-100',
                    'text' => 'text-purple-800',
                    'ring' => 'ring-purple-200',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>',
                    'label' => 'Đã gửi hàng'
                    ],
                    'delivered' => [
                    'bg' => 'bg-gradient-to-r from-green-100 to-emerald-100',
                    'text' => 'text-green-800',
                    'ring' => 'ring-green-200',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
                    'label' => 'Giao thành công'
                    ],
                    'cancelled' => [
                    'bg' => 'bg-gradient-to-r from-red-100 to-pink-100',
                    'text' => 'text-red-800',
                    'ring' => 'ring-red-200',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
                    'label' => 'Đã hủy'
                    ],
                    ];
                    $config = $statusConfig[$order->status] ?? [
                    'bg' => 'bg-gray-100',
                    'text' => 'text-gray-800',
                    'ring' => 'ring-gray-200',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                    'label' => $order->status
                    ];
                    @endphp
                    <div class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold {{ $config['bg'] }} {{ $config['text'] }} ring-1 {{ $config['ring'] }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $config['icon'] !!}
                        </svg>
                        {{ $config['label'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Products & Payment -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Products Section -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <h2 class="text-xl font-semibold text-white">Sản phẩm trong đơn hàng</h2>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse ($items as $it)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 ring-1 ring-gray-200">
                                        <img src="{{ $it->image_url ?? '/images/placeholder.png' }}"
                                            alt="{{ $it->name }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $it->name }}</h3>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Số lượng: <span class="font-medium">{{ $it->quantity }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            Đơn giá: <span class="font-medium">{{ number_format($it->price, 0, ',', '.') }} đ</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-shrink-0 text-right">
                                    <div class="text-xl font-bold text-gray-900">
                                        {{ number_format($it->price * $it->quantity, 0, ',', '.') }}<span class="text-sm font-normal text-gray-600 ml-1">đ</span>
                                    </div>
                                    <div class="text-sm text-gray-500">Thành tiền</div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-gray-600">Không có sản phẩm trong đơn hàng này</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <h2 class="text-xl font-semibold text-white">Thông tin thanh toán</h2>
                        </div>
                    </div>

                    <div class="p-6">
                        @if ($payment)
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Số tiền thanh toán</span>
                                <span class="text-xl font-bold text-gray-900">{{ number_format($payment->amount, 0, ',', '.') }} đ</span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Phương thức thanh toán</span>
                                <span class="font-semibold text-gray-900 uppercase bg-gray-100 px-3 py-1 rounded-lg">{{ $payment->method }}</span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Trạng thái thanh toán</span>
                                @php
                                $paymentStatusConfig = [
                                'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => 'Đang chờ'],
                                'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Hoàn thành'],
                                'failed' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Thất bại'],
                                ];
                                $pConfig = $paymentStatusConfig[$payment->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => ucfirst($payment->status)];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $pConfig['bg'] }} {{ $pConfig['text'] }}">
                                    {{ $pConfig['label'] }}
                                </span>
                            </div>

                            @if ($payment->paid_at)
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-600">Thời gian thanh toán</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <p class="text-gray-600">Chưa có thông tin thanh toán</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="space-y-8">
                <!-- Order Summary Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden sticky top-8">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <h2 class="text-xl font-semibold text-white">Tóm tắt đơn hàng</h2>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Order Details -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Mã đơn hàng</span>
                                <span class="font-bold text-gray-900">#{{ $order->id }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Ngày đặt hàng</span>
                                <div class="text-right">
                                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}</div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Trạng thái</span>
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }} ring-1 {{ $config['ring'] }}">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $config['icon'] !!}
                                    </svg>
                                    {{ $config['label'] }}
                                </div>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Thanh toán</span>
                                <span class="font-semibold text-gray-900 uppercase bg-gray-100 px-2 py-1 rounded text-sm">{{ $order->payment_method }}</span>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                            @php
                            $subtotal = $items->sum(fn($i) => $i->price * $i->quantity);
                            @endphp

                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Tạm tính ({{ $items->count() }} sản phẩm)</span>
                                <span class="font-medium text-gray-900">{{ number_format($subtotal, 0, ',', '.') }} đ</span>
                            </div>

                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Phí vận chuyển</span>
                                <span class="font-medium text-gray-900">
                                    @if($order->total - $subtotal > 0)
                                    {{ number_format($order->total - $subtotal, 0, ',', '.') }} đ
                                    @else
                                    Miễn phí
                                    @endif
                                </span>
                            </div>

                            <hr class="border-gray-200">

                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Tổng cộng</span>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-indigo-600">{{ number_format($order->total, 0, ',', '.') }}</div>
                                    <div class="text-sm text-gray-500">VNĐ</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-4 space-y-3">
                            @if($order->status === 'delivered')
                            <button class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-105">
                                Đánh giá sản phẩm
                            </button>
                            @endif

                            @if($order->status === 'pending')
                            <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST"
                                onsubmit="return confirm('Bạn chắc muốn hủy đơn #{{ $order->id }}?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-105">
                                    Hủy đơn hàng
                                </button>
                            </form>
                            @endif


                            <button class="w-full bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-xl transition-all duration-200 hover:shadow-md">
                                Liên hệ hỗ trợ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection