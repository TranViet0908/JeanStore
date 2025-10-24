@extends('layouts.admin')
@section('title','Đơn hàng')
@section('page-title','Đơn hàng')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đơn hàng</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Mã đơn, email">
                        <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Trạng thái --</option>
                        @foreach(['pending'=>'Chờ xử lý','processing'=>'Đang xử lý','completed'=>'Hoàn tất','canceled'=>'Hủy'] as $val=>$text)
                        <option value="{{ $val }}" @selected(request('status')===$val)>{{ $text }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="payment" class="form-select">
                        <option value="">-- Thanh toán --</option>
                        @foreach(['cod'=>'COD','vnpay'=>'VNPAY','momo'=>'MoMo','stripe'=>'Stripe'] as $val=>$text)
                        <option value="{{ $val }}" @selected(request('payment')===$val)>{{ $text }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                        <tr>
                            <td><span class="badge bg-secondary">#{{ $o->id }}</span></td>
                            <td class="fw-semibold">{{ $o->order_number ?? ('#'.$o->id) }}</td>
                            <td>
                                <div>{{ $o->customer_name ?? ($o->user->name ?? 'Khách') }}</div>
                                <div class="text-muted small">{{ $o->customer_email ?? ($o->user->email ?? '') }}</div>
                            </td>
                            <td>
                                @php
                                $moneyCol = $moneyCol ?? collect(['grand_total','total','total_amount','amount','total_price'])
                                ->first(fn($c)=>Schema::hasColumn('orders',$c));
                                $totalVal = $moneyCol ? $o->{$moneyCol} : null;
                                @endphp
                                {{ $totalVal !== null ? number_format($totalVal).'đ' : '—' }}
                            </td>
                            <td><span class="badge bg-info">{{ strtoupper($o->payment_method ?? 'N/A') }}</span></td>
                            <td>
                                @php
                                $status = (string)($o->status ?? 'pending');

                                // Chuẩn hóa chính tả nếu có
                                if ($status === 'canceled') $status = 'cancelled';

                                // Màu theo trạng thái (Bootstrap)
                                $badgeClass = match ($status) {
                                'pending' => 'bg-warning text-dark',
                                'processing' => 'bg-primary',
                                'shipped' => 'bg-info',
                                'delivered' => 'bg-success',
                                'completed' => 'bg-success',
                                'paid' => 'bg-success',
                                'failed' => 'bg-danger',
                                'refunded' => 'bg-secondary',
                                'cancelled' => 'bg-danger',
                                default => 'bg-light text-body' // phòng hờ trạng thái lạ
                                };
                                @endphp

                                <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                            </td>

                            <td>{{ optional($o->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.edit',$o) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-clipboard-check"></i></a>
                                <a href="{{ route('admin.orders.show',$o) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Không có đơn hàng</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($orders,'links'))
        <div class="card-footer bg-white">{{ $orders->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection