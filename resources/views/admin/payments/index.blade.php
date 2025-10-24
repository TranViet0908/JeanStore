@extends('layouts.admin')
@section('title','Quản lý thanh toán')
@section('page-title','Quản lý thanh toán')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Thanh toán</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800">
        <i class="fas fa-credit-card me-2"></i>Quản lý thanh toán
      </h1>
      <p class="text-muted">Theo dõi và quản lý các giao dịch thanh toán</p>
    </div>
    <div>
      <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tạo thanh toán mới
      </a>
    </div>
  </div>

  <!-- Filter Card -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fas fa-filter me-2"></i>Bộ lọc
      </h6>
    </div>
    <div class="card-body">
      <form class="row align-items-end">
        <div class="col-md-3 mb-2">
          <label class="form-label font-weight-bold">Trạng thái</label>
          <select name="status" class="form-control">
            <option value="">-- Tất cả trạng thái --</option>
            @foreach(['pending' => 'Đang chờ', 'completed' => 'Hoàn thành', 'failed' => 'Thất bại'] as $key => $label)
            <option value="{{ $key }}" @selected(request('status')===$key)>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3 mb-2">
          <button type="submit" class="btn btn-info btn-block">
            <i class="fas fa-search me-2"></i>Lọc kết quả
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Payments Table -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fas fa-list me-2"></i>Danh sách thanh toán
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th class="text-center">
                <i class="fas fa-hashtag me-1"></i>ID
              </th>
              <th>
                <i class="fas fa-shopping-cart me-1"></i>Đơn hàng
              </th>
              <th class="text-right">
                <i class="fas fa-money-bill-wave me-1"></i>Số tiền
              </th>
              <th>
                <i class="fas fa-wallet me-1"></i>Phương thức
              </th>
              <th>
                <i class="fas fa-building me-1"></i>Nhà cung cấp
              </th>
              <th class="text-center">
                <i class="fas fa-flag me-1"></i>Trạng thái
              </th>
              <th class="text-center">
                <i class="fas fa-cogs me-1"></i>Thao tác
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $p)
            <tr>
              <td class="text-center font-weight-bold">#{{ $p->id }}</td>
              <td>
                <a href="#" class="text-decoration-none">
                  <i class="fas fa-receipt me-1 text-muted"></i>
                  Đơn hàng #{{ $p->order_id }}
                </a>
              </td>
              <td class="text-right font-weight-bold text-success">
                {{ number_format($p->amount,0,',','.') }}₫
              </td>
              <td>
                <span class="badge badge-info badge-pill font-weight-bold text-dark">
                  @switch($p->method)
                  @case('cash')
                  <i class="fas fa-money-bill me-1"></i>Tiền mặt
                  @break
                  @case('credit_card')
                  <i class="fas fa-credit-card me-1"></i>Thẻ tín dụng
                  @break
                  @case('bank_transfer')
                  <i class="fas fa-university me-1"></i>Chuyển khoản
                  @break
                  @case('e_wallet')
                  <i class="fas fa-mobile-alt me-1"></i>Ví điện tử
                  @break
                  @default
                  {{ $p->method }}
                  @endswitch
                </span>
              </td>
              <td>
                @if($p->provider)
                <span class="badge badge-info badge-pill font-weight-bold text-dark">
                  {{ strtoupper($p->provider) }}
                </span>
                @else
                <span class="text-muted">-</span>
                @endif
              </td>
              <td class="text-center">
                <span class="badge badge-pill font-weight-bold
                                    @switch($p->status)
                                        @case('pending')
                                            bg-warning text-dark
                                            @break
                                        @case('completed')
                                            bg-success text-white
                                            @break
                                        @case('failed')
                                            bg-danger text-white
                                            @break
                                        @default
                                            bg-secondary text-white
                                    @endswitch
                                ">
                  @switch($p->status)
                  @case('pending')
                  <i class="fas fa-clock me-1"></i>Đang chờ
                  @break
                  @case('completed')
                  <i class="fas fa-check me-1"></i>Hoàn thành
                  @break
                  @case('failed')
                  <i class="fas fa-times me-1"></i>Thất bại
                  @break
                  @default
                  {{ $p->status }}
                  @endswitch
                </span>
              </td>
              <td class="text-center">
                <div class="btn-group" role="group">
                  <a href="{{ route('admin.payments.show',$p) }}"
                    class="btn btn-sm btn-info"
                    title="Xem chi tiết">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.payments.edit',$p) }}"
                    class="btn btn-sm btn-warning"
                    title="Chỉnh sửa">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.payments.destroy',$p) }}"
                    method="post"
                    class="d-inline"
                    onsubmit="return confirm('Bạn có chắc muốn xóa thanh toán này?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                      class="btn btn-sm btn-danger"
                      title="Xóa">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4">
                <div class="text-muted">
                  <i class="fas fa-inbox fa-3x mb-3"></i>
                  <p class="mb-0">Chưa có thanh toán nào</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Pagination -->
  @if($rows->hasPages())
  <div class="d-flex justify-content-center mt-4">
    {{ $rows->links() }}
  </div>
  @endif
</div>
@endsection