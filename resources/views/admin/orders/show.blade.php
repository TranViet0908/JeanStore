@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng #'.$order->id)

@section('content')
@php
  $u        = $order->user ?? null;
  $items    = $order->items ?? collect();
  $subtotal = $items->sum(fn($i) => (float)($i->price ?? 0) * (int)($i->quantity ?? 1));
  $total    = (float)($order->total ?? $subtotal);
  $status   = (string)($order->status ?? 'pending');
  $method   = (string)($order->payment_method ?? 'COD');

  $badge = [
    'pending'    => 'secondary',
    'processing' => 'info',
    'shipped'    => 'primary',
    'delivered'  => 'success',
    'cancelled'  => 'danger',
  ][$status] ?? 'secondary';
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Đơn #{{ $order->id }}</h1>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning">Sửa</a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Quay lại</a>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-header">Thông tin đơn</div>
      <div class="card-body">
        <div class="mb-2"><span class="text-muted">Mã đơn:</span> #{{ $order->id }}</div>
        <div class="mb-2"><span class="text-muted">Trạng thái:</span>
          <span class="badge bg-{{ $badge }}">{{ ucfirst($status) }}</span>
        </div>
        <div class="mb-2"><span class="text-muted">Thanh toán:</span> {{ $method }}</div>
        <div class="mb-2"><span class="text-muted">Tổng tiền:</span>
          <strong>{{ number_format($total,0,',','.') }} đ</strong>
        </div>
        <div class="mb-2"><span class="text-muted">Tạo lúc:</span> {{ $order->created_at }}</div>
        <div class="mb-2"><span class="text-muted">Cập nhật:</span> {{ $order->updated_at }}</div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-header">Khách hàng</div>
      <div class="card-body">
        <div class="mb-2"><span class="text-muted">Tên:</span> {{ $u?->full_name ?? $u?->name ?? 'N/A' }}</div>
        <div class="mb-2"><span class="text-muted">Email:</span> {{ $u?->email ?? 'N/A' }}</div>
        <div class="mb-2"><span class="text-muted">User ID:</span> {{ $u?->id ?? 'N/A' }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
