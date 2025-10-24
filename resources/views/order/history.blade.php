@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - Jeans Store')

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Đơn hàng của tôi</h1>

    @if($orders->isEmpty())
      <div class="bg-white rounded-xl p-8 text-center text-gray-600 shadow">
        Bạn chưa có đơn hàng nào.
        <a href="{{ route('home') }}" class="text-blue-700 font-semibold hover:underline ml-1">Mua ngay</a>
      </div>
    @else
      <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mã đơn</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ngày đặt</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tổng</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Thanh toán</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Trạng thái</th>
                <th class="px-6 py-3"></th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @foreach($orders as $o)
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 font-semibold">#{{ $o->id }}</td>
                  <td class="px-6 py-4 text-gray-600">{{ $o->created_at->format('d/m/Y H:i') }}</td>
                  <td class="px-6 py-4 font-semibold">{{ number_format($o->total,0,',','.') }}₫</td>
                  <td class="px-6 py-4">{{ strtoupper($o->payment_method) }}</td>
                  <td class="px-6 py-4">
                    @php
                      $badge = [
                        'processing' => 'bg-yellow-100 text-yellow-800',
                        'paid' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800'
                      ][$o->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm {{ $badge }}">{{ ucfirst($o->status) }}</span>
                  </td>
                  <td class="px-6 py-4 text-right">
                    <a href="{{ route('order.detail', $o->id) }}"
                       class="text-blue-700 font-semibold hover:underline">Chi tiết</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="p-4">
          {{ $orders->links() }}
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
