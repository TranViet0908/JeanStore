@extends('layouts.app')

@section('title', 'Đặt hàng thành công - Jeans Store')

@section('content')
<div class="container mx-auto px-4 py-16">
  <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow p-8 text-center">
    <div class="mx-auto w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
      <i class="fas fa-check text-green-600 text-2xl"></i>
    </div>
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Đặt hàng thành công</h1>
    <p class="text-gray-600 mb-6">Cảm ơn bạn đã mua sắm tại Jeans Store.</p>

    <div class="bg-gray-50 rounded-xl p-4 text-left mb-6">
      <p class="text-sm text-gray-600">Mã đơn hàng</p>
      <p class="text-lg font-semibold text-gray-800">#{{ $order->id }}</p>
      <p class="text-sm text-gray-600 mt-2">Tổng tiền</p>
      <p class="text-lg font-semibold text-gray-800">{{ number_format($order->total,0,',','.') }}₫</p>
      <p class="text-sm text-gray-600 mt-2">Thanh toán</p>
      <p class="text-lg font-semibold text-gray-800">{{ strtoupper($order->payment_method) }}</p>
    </div>

    <div class="flex gap-3 justify-center">
      <a class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-semibold"
         href="{{ route('order.detail', $order->id) }}">Xem chi tiết đơn</a>
      <a class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-3 rounded-lg font-semibold"
         href="{{ route('home') }}">Tiếp tục mua sắm</a>
    </div>
  </div>
</div>
@endsection
