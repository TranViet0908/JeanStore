@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng - Jeans Store')

@section('content')
@php
  $items = isset($items) ? collect($items) : (isset($order->items) ? collect($order->items) : collect());

  $subtotal = isset($subtotal)
      ? (int)$subtotal
      : $items->sum(function ($i) {
          $price = (int) data_get($i, 'price', (int) data_get($i, 'product.price', 0));
          $qty   = (int) data_get($i, 'quantity', 1);
          return $price * $qty;
        });

  $shipping   = isset($shipping) ? (int)$shipping : 0;
  $grand      = max(0, $subtotal + $shipping);

  // giảm giá từ đơn
  $discount   = (int) ($order->discount ?? 0);
  $couponCode = $order->coupon_code ?? null;

  // tổng sau giảm: ưu tiên cột total của đơn nếu đã lưu
  $grandAfter = isset($order->total) ? (int) round($order->total) : max(0, $grand - $discount);

  $statusRaw  = $order->status ?? 'pending';
  $isPaid     = in_array($statusRaw, [1,'1','paid','Paid','PAID','completed','success'], true);
  $statusText = $isPaid ? 'Paid' : (in_array($statusRaw,[0,'0','pending','Pending'],true) ? 'Pending' : ucfirst((string)$statusRaw));

  $payMethod = strtoupper((string)($order->payment_method ?? 'VNPAY'));
@endphp

<div class="container mx-auto px-4 py-8">
  <div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-800">Đơn hàng #{{ $order->id }}</h1>
      <a href="{{ route('order.history') }}" class="text-blue-700 hover:underline">Quay lại lịch sử</a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
      {{-- Left: items + shipping address --}}
      <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Sản phẩm</h2>

          @forelse($items as $line)
            @php
              $img   = data_get($line, 'image', data_get($line, 'product.image_url', 'https://via.placeholder.com/72x72'));
              $name  = data_get($line, 'name',  data_get($line, 'product.name', 'Sản phẩm'));
              $price = (int) data_get($line, 'price', (int) data_get($line, 'product.price', 0));
              $qty   = (int) data_get($line, 'quantity', 1);
            @endphp
            <div class="flex items-center gap-4 py-3 border-b last:border-b-0">
              <img src="{{ $img }}" class="w-16 h-16 object-cover rounded-lg" alt="">
              <div class="flex-1">
                <p class="font-medium text-gray-800">{{ $name }}</p>
                <p class="text-sm text-gray-500">
                  Size: {{ data_get($line,'size','—') }} | Màu: {{ data_get($line,'color','—') }}
                </p>
              </div>
              <div class="text-right">
                <p class="text-sm text-gray-500">x{{ $qty }}</p>
                <p class="font-semibold">{{ number_format($price * $qty, 0, ',', '.') }}₫</p>
              </div>
            </div>
          @empty
            <p class="text-gray-600">Không có sản phẩm trong đơn này.</p>
          @endforelse
        </div>

        <div class="bg-white rounded-xl shadow p-6">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Địa chỉ giao hàng</h2>
          <p class="text-gray-800 font-medium">{{ $order->shipping_name ?? auth()->user()->name }}</p>
          <p class="text-gray-600">{{ $order->shipping_phone ?? '' }}</p>
          <p class="text-gray-600">{{ $order->shipping_address ?? '' }}</p>
          <p class="text-gray-600">
            {{ $order->shipping_city ?? '' }}{{ $order->shipping_zip ? ', '.$order->shipping_zip : '' }}
          </p>
        </div>
      </div>

      {{-- Right: summary + pay --}}
      <aside class="space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Tóm tắt</h2>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span class="text-gray-600">Tạm tính</span>
              <span class="font-semibold">{{ number_format($subtotal,0,',','.') }}₫</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Vận chuyển</span>
              <span class="font-semibold">{{ number_format($shipping,0,',','.') }}₫</span>
            </div>

            @if($discount > 0)
            <div class="flex justify-between text-emerald-700">
              <span>Giảm {{ $couponCode ? '(' . $couponCode . ')' : '' }}</span>
              <span class="font-semibold">-{{ number_format($discount,0,',','.') }}₫</span>
            </div>
            @endif

            <div class="flex justify-between text-lg font-bold">
              <span>Tổng</span>
              <span class="text-blue-700">{{ number_format($grandAfter,0,',','.') }}₫</span>
            </div>
          </div>

          <div class="mt-4 text-sm text-gray-600 space-y-1">
            <p>Thanh toán: <span class="font-semibold">{{ $payMethod }}</span></p>
            <p>Trạng thái: <span class="font-semibold">{{ $statusText }}</span></p>
          </div>

          <form method="GET" action="{{ route('payments.checkout') }}" class="mt-5">
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="amount"   value="{{ $grandAfter }}">
            <button type="submit"
              class="px-4 py-2 rounded bg-gray-900 text-white disabled:opacity-50 disabled:cursor-not-allowed w-full"
              {{ $isPaid ? 'disabled' : '' }}>
              {{ $isPaid ? 'Đã thanh toán' : 'Thanh toán' }}
            </button>
          </form>
        </div>
      </aside>
    </div>
  </div>
</div>
@endsection
