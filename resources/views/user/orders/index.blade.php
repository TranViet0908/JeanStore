@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Đơn hàng của tôi</h1>
                    <p class="text-gray-600">Quản lý và theo dõi tất cả đơn hàng của bạn</p>
                </div>
                <div class="hidden sm:flex items-center space-x-3">
                    <div class="flex items-center px-3 py-2 bg-white rounded-lg shadow-sm border border-gray-200">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">{{ $orders->total() ?? $orders->count() }} đơn hàng</span>
                    </div>
                </div>
            </div>
        </div>

        @if ($orders->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="bg-white rounded-2xl shadow-xl p-12 max-w-md mx-auto">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa có đơn hàng nào</h3>
                <p class="text-gray-600 mb-6">Bạn chưa thực hiện đơn hàng nào. Hãy bắt đầu mua sắm ngay!</p>
                <a href="{{ route('products.index') ?? '#' }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition duration-200 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Bắt đầu mua sắm
                </a>
            </div>
        </div>
        @else
        <!-- Orders Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Đơn hàng</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ngày tạo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tổng tiền</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($orders as $o)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">#{{ $o->id }}</div>
                                        <div class="text-xs text-gray-500">ID: {{ str_pad($o->id, 6, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($o->created_at)->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($o->created_at)->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-lg font-bold text-gray-900">
                                    {{ number_format($o->total, 0, ',', '.') }}<span class="text-sm font-normal text-gray-600 ml-1">đ</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
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
                                $config = $statusConfig[$o->status] ?? [
                                'bg' => 'bg-gray-100',
                                'text' => 'text-gray-800',
                                'ring' => 'ring-gray-200',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                                'label' => $o->status
                                ];
                                @endphp
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }} ring-1 {{ $config['ring'] }}">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $config['icon'] !!}
                                    </svg>
                                    {{ $config['label'] }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('user.orders.show', $o->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 transition-all duration-200 hover:shadow-md hover:border-gray-400 transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($orders, 'hasPages') && $orders->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white rounded-xl shadow-lg p-1">
                {{ $orders->onEachSide(1)->links() }}
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

<style>
    /* Custom pagination styles */
    .pagination {
        @apply flex items-center space-x-1;
    }

    .pagination .page-link {
        @apply px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200;
    }

    .pagination .page-item.active .page-link {
        @apply bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg;
    }

    .pagination .page-item.disabled .page-link {
        @apply text-gray-400 cursor-not-allowed;
    }
</style>
@endsection