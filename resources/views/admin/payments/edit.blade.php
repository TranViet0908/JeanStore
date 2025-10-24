@extends('layouts.admin')
@section('title','Chỉnh sửa thanh toán #'.$payment->id)
@section('page-title','Chỉnh sửa thanh toán #'.$payment->id)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Thanh toán</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.payments.show', $payment) }}">Thanh toán #{{ $payment->id }}</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Chỉnh sửa thanh toán #{{ $payment->id }}</h1>
            <p class="text-muted">Cập nhật thông tin thanh toán</p>
        </div>
        <div>
            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i>Xem chi tiết
            </a>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Cập nhật thông tin thanh toán
                    </h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.payments.update',$payment) }}">
                        @csrf @method('PUT')
                        
                        <!-- Order Selection -->
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-shopping-cart me-2 text-primary"></i>Đơn hàng
                            </label>
                            <select name="order_id" class="form-control form-control-lg">
                                @foreach($orders as $o)
                                    <option value="{{ $o->id }}" @selected($o->id===$payment->order_id)>
                                        Đơn hàng #{{ $o->id }} - {{ number_format($o->total,0,',','.') }}₫
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Amount -->
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-money-bill-wave me-2 text-success"></i>Số tiền
                            </label>
                            <div class="input-group input-group-lg">
                                <input type="number" step="0.01" name="amount" value="{{ $payment->amount }}" class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">₫</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method & Provider -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-wallet me-2 text-info"></i>Phương thức thanh toán
                                    </label>
                                    <select name="method" class="form-control form-control-lg" required>
                                        @foreach(['cash' => 'Tiền mặt', 'credit_card' => 'Thẻ tín dụng', 'bank_transfer' => 'Chuyển khoản', 'e_wallet' => 'Ví điện tử'] as $key => $label)
                                            <option value="{{ $key }}" @selected($payment->method===$key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-building me-2 text-warning"></i>Nhà cung cấp
                                    </label>
                                    <select name="provider" class="form-control form-control-lg">
                                        <option value="">-- Chọn nhà cung cấp --</option>
                                        @foreach(['momo' => 'MoMo', 'zalopay' => 'ZaloPay', 'vnpay' => 'VNPay', 'stripe' => 'Stripe'] as $key => $label)
                                            <option value="{{ $key }}" @selected($payment->provider===$key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Paid Date -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-flag me-2 text-primary"></i>Trạng thái
                                    </label>
                                    <select name="status" class="form-control form-control-lg" required>
                                        @foreach(['pending' => 'Đang chờ', 'completed' => 'Hoàn thành', 'failed' => 'Thất bại'] as $key => $label)
                                            <option value="{{ $key }}" @selected($payment->status===$key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-calendar-check me-2 text-success"></i>Thời gian thanh toán
                                    </label>
                                    <input type="datetime-local" name="paid_at"
                                           value="{{ $payment->paid_at? $payment->paid_at->format('Y-m-d\TH:i') : '' }}"
                                           class="form-control form-control-lg">
                                </div>
                            </div>
                        </div>

                        <!-- Provider Transaction ID -->
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-hashtag me-2 text-secondary"></i>Mã giao dịch nhà cung cấp
                            </label>
                            <input type="text" name="provider_txn_id" value="{{ $payment->provider_txn_id }}" class="form-control form-control-lg" placeholder="Nhập mã giao dịch (nếu có)">
                        </div>

                        <!-- Action Buttons -->
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <button type="submit" class="btn btn-warning btn-lg btn-block">
                                            <i class="fas fa-save me-2"></i>Cập nhật thanh toán
                                        </button>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-lg btn-block">
                                            <i class="fas fa-times me-2"></i>Hủy bỏ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection