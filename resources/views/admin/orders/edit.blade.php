@extends('layouts.admin')

@section('title', 'Sửa đơn hàng #'.$order->id)

@section('content')
@php
  $options = ['pending','processing','shipped','delivered','cancelled'];
  $status  = (string)($order->status ?? 'pending');
  $method  = (string)($order->payment_method ?? 'COD');
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Sửa đơn #{{ $order->id }}</h1>
  <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">Xem</a>
</div>

<form action="{{ route('admin.orders.update', $order) }}" method="POST" class="card">
  @csrf
  @method('PUT')

  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
          @foreach($options as $opt)
            <option value="{{ $opt }}" @selected($status===$opt)>{{ ucfirst($opt) }}</option>
          @endforeach
        </select>
        @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Phương thức thanh toán</label>
        <select name="payment_method" class="form-select">
          <option value="COD" @selected($method==='COD')>COD</option>
          <option value="online" @selected($method==='online')>Online</option>
        </select>
        @error('payment_method')<div class="text-danger small">{{ $message }}</div>@enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Tổng tiền</label>
        <input type="text" class="form-control" value="{{ number_format($order->total ?? 0,0,',','.') }} đ" disabled>
      </div>

      <div class="col-md-6">
        <label class="form-label">Khách hàng</label>
        <input type="text" class="form-control" value="{{ $order->user?->full_name ?? $order->user?->name ?? ('User #'.$order->user_id) }}" disabled>
      </div>
    </div>
  </div>

  <div class="card-footer d-flex justify-content-between">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Hủy</a>
    <button type="submit" class="btn btn-primary">Lưu</button>
  </div>
</form>

@endsection
