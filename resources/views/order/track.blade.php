@extends('layouts.app')

@section('title', 'Tra cứu đơn hàng - Jeans Store')

@section('content')
<div class="container mx-auto px-4 py-10">
  <div class="max-w-xl mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Tra cứu đơn hàng</h1>
    <form method="POST" action="{{ route('order.track.submit') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nhập mã đơn hàng (#ID)</label>
        <input name="order_id" value="{{ old('order_id') }}" required
               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('order_id') border-red-500 @enderror">
        @error('order_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
      </div>
      <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg">Tra cứu</button>
    </form>

    @isset($found)
      <div class="mt-6">
        @if($found)
          <div class="p-4 rounded-lg bg-green-50 text-green-800">
            Tìm thấy đơn #{{ $order->id }} | Trạng thái: <b>{{ ucfirst($order->status) }}</b>
            <a class="ml-2 text-blue-700 hover:underline" href="{{ route('order.detail', $order->id) }}">Xem chi tiết</a>
          </div>
        @else
          <div class="p-4 rounded-lg bg-red-50 text-red-700">Không tìm thấy đơn phù hợp.</div>
        @endif
      </div>
    @endisset
  </div>
</div>
@endsection
