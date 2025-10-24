@extends('layouts.admin')
@section('title', 'Thanh toán #' . $payment->id . ' - BanQuanJeans')
@section('page-title', 'Chi tiết thanh toán #' . $payment->id)

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Thanh toán</a></li>
      <li class="breadcrumb-item active">Thanh toán #{{ $payment->id }}</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800">
        <i class="fas fa-credit-card me-2"></i>Thanh toán #{{ $payment->id }}
      </h1>
      <p class="text-muted">Chi tiết thông tin giao dịch thanh toán</p>
    </div>
    <div>
      <a href="{{ route('admin.payments.edit',$payment) }}" class="btn btn-warning me-2">
        <i class="fas fa-edit me-2"></i>Chỉnh sửa
      </a>
      <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
      </a>
    </div>
  </div>

  <div class="row">
    <!-- Payment Status Card -->
    <div class="col-lg-4 mb-4">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-flag me-2"></i>Trạng thái thanh toán
          </h6>
        </div>
        <div class="card-body text-center">
          <div class="mb-3">
            @switch($payment->status)
            @case('pending')
            <i class="fas fa-clock fa-4x text-warning mb-3"></i>
            <h4 class="text-warning">Đang chờ xử lý</h4>
            @break
            @case('completed')
            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
            <h4 class="text-success">Hoàn thành</h4>
            @break
            @case('failed')
            <i class="fas fa-times-circle fa-4x text-danger mb-3"></i>
            <h4 class="text-danger">Thất bại</h4>
            @break
            @default
            <i class="fas fa-question-circle fa-4x text-secondary mb-3"></i>
            <h4 class="text-secondary">{{ ucfirst($payment->status) }}</h4>
            @endswitch
          </div>
          <div class="h2 font-weight-bold text-primary mb-2">
            {{ number_format($payment->amount,0,',','.') }}₫
          </div>
          <p class="text-muted mb-0">Số tiền thanh toán</p>
        </div>
      </div>
    </div>

    <!-- Payment Details -->
    <div class="col-lg-8 mb-4">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-info-circle me-2"></i>Thông tin chi tiết
          </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td class="font-weight-bold bg-light" width="30%">
                    <i class="fas fa-hashtag me-2 text-primary"></i>Mã thanh toán
                  </td>
                  <td class="font-weight-bold">#{{ $payment->id }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-shopping-cart me-2 text-info"></i>Đơn hàng
                  </td>
                  <td>
                    <a href="#" class="text-decoration-none">
                      Đơn hàng #{{ $payment->order_id }}
                    </a>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-money-bill-wave me-2 text-success"></i>Số tiền
                  </td>
                  <td class="font-weight-bold text-success h5 mb-0">
                    {{ number_format($payment->amount,0,',','.') }}₫
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-wallet me-2 text-warning"></i>Phương thức
                  </td>
                  <td>
                    <span class="badge badge-info badge-pill font-weight-bold text-dark">
                      @switch($payment->method)
                      @case('cash')
                      <i class="fas fa-money-bill me-1"></i>Tiền mặt
                      @break
                      @case('credit_card')
                      <i class="fas fa-credit-card me-1"></i>Thẻ tín dụng
                      @break
                      @case('bank_transfer')
                      <i class="fas fa-university me-1"></i>Chuyển khoản ngân hàng
                      @break
                      @case('e_wallet')
                      <i class="fas fa-mobile-alt me-1"></i>Ví điện tử
                      @break
                      @default
                      {{ $payment->method }}
                      @endswitch
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-building me-2 text-secondary"></i>Nhà cung cấp
                  </td>
                  <td>
                    @if($payment->provider)
                    <span class="badge badge-info badge-pill font-weight-bold text-dark">
                      {{ strtoupper($payment->provider) }}
                    </span>
                    @else
                    <span class="text-muted">Không có</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-flag me-2 text-primary"></i>Trạng thái
                  </td>
                  <td>
                    <span class="badge badge-pill font-weight-bold
                                            @switch($payment->status)
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
                      @switch($payment->status)
                      @case('pending')
                      <i class="fas fa-clock me-1"></i>Đang chờ xử lý
                      @break
                      @case('completed')
                      <i class="fas fa-check me-1"></i>Hoàn thành
                      @break
                      @case('failed')
                      <i class="fas fa-times me-1"></i>Thất bại
                      @break
                      @default
                      {{ $payment->status }}
                      @endswitch
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-calendar-check me-2 text-success"></i>Thời gian thanh toán
                  </td>
                  <td>
                    @if($payment->paid_at)
                    <span class="text-success font-weight-bold">
                      {{ $payment->paid_at->format('d/m/Y H:i:s') }}
                    </span>
                    @else
                    <span class="text-muted">Chưa thanh toán</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-hashtag me-2 text-info"></i>Mã giao dịch
                  </td>
                  <td>
                    @if($payment->provider_txn_id)
                    <code class="bg-light p-1 rounded">{{ $payment->provider_txn_id }}</code>
                    @else
                    <span class="text-muted">Không có</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-calendar-plus me-2 text-muted"></i>Ngày tạo
                  </td>
                  <td>{{ optional($payment->created_at)->format('d/m/Y H:i:s') ?? '-' }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-calendar-edit me-2 text-muted"></i>Cập nhật lần cuối
                  </td>
                  <td>{{ optional($payment->updated_at)->format('d/m/Y H:i:s') ?? '-' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Provider Payload -->
  @if($payment->provider_payload)
  <div class="row">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-code me-2"></i>Dữ liệu từ nhà cung cấp
          </h6>
        </div>
        <div class="card-body">
          <div class="bg-light p-3 rounded">
            <pre class="mb-0 text-sm"><code>{{ json_encode($payment->provider_payload, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</code></pre>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Action Buttons -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-cogs me-2"></i>Thao tác
          </h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 mb-2">
              <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-warning btn-block">
                <i class="fas fa-edit me-2"></i>Chỉnh sửa thanh toán
              </a>
            </div>
            <div class="col-md-4 mb-2">
              <a href="{{ route('admin.payments.index') }}" class="btn btn-info btn-block">
                <i class="fas fa-list me-2"></i>Danh sách thanh toán
              </a>
            </div>
            <div class="col-md-4 mb-2">
              <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline w-100">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="btn btn-danger btn-block"
                  onclick="return confirm('Bạn có chắc muốn xóa thanh toán này?')">
                  <i class="fas fa-trash me-2"></i>Xóa thanh toán
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection