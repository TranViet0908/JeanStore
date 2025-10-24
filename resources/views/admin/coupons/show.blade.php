@extends('layouts.admin')
@section('title','Chi tiết mã giảm giá #'.$coupon->id)
@section('page-title','Chi tiết mã giảm giá #'.$coupon->id)

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a></li>
      <li class="breadcrumb-item active">Mã #{{ $coupon->id }}</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-ticket-alt me-2"></i>Mã giảm giá #{{ $coupon->id }}</h1>
      <p class="text-muted">Xem chi tiết thông tin mã giảm giá</p>
    </div>
    <div class="btn-group" role="group">
      <a href="{{ route('admin.coupons.edit',$coupon) }}" class="btn btn-primary"><i class="fas fa-edit me-1"></i>Chỉnh sửa</a>
      <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary"><i class="fas fa-list me-1"></i>Danh sách</a>
    </div>
  </div>

  <div class="row">
    <!-- Thông tin chi tiết -->
    <div class="col-lg-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Thông tin chi tiết</h6>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-sm-3 text-muted fw-bold"><i class="fas fa-hashtag me-1"></i>ID</div>
            <div class="col-sm-9">#{{ $coupon->id }}</div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-3 text-muted fw-bold"><i class="fas fa-code me-1"></i>Mã giảm giá</div>
            <div class="col-sm-9">
              <span class="badge badge-info badge-pill fw-bold text-dark font-monospace fs-5">{{ $coupon->code }}</span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-3 text-muted fw-bold"><i class="fas fa-percentage me-1"></i>Loại & giá trị</div>
            <div class="col-sm-9">
              <span class="badge badge-success badge-pill text-dark font-monospace fs-6">
                @if($coupon->type === 'percent')
                  {{ number_format((int)$coupon->value,0,',','.') }}%
                @else
                  {{ number_format((int)$coupon->value,0,',','.') }}₫
                @endif
              </span>
              <span class="text-muted small ms-2">({{ $coupon->type }})</span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-3 text-muted fw-bold"><i class="fas fa-sliders-h me-1"></i>Điều kiện</div>
            <div class="col-sm-9">
              <div class="small mb-1">Đơn tối thiểu:
                <strong>{{ (int)$coupon->min_order_total > 0 ? number_format((int)$coupon->min_order_total,0,',','.') . '₫' : 'Không' }}</strong>
              </div>
              <div class="small">Giảm tối đa:
                <strong>{{ (int)$coupon->max_discount > 0 ? number_format((int)$coupon->max_discount,0,',','.') . '₫' : 'Không' }}</strong>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-3 text-muted fw-bold"><i class="fas fa-user-check me-1"></i>Lượt dùng</div>
            <div class="col-sm-9">
              <span class="badge badge-light text-dark font-monospace">{{ (int)$coupon->used }}/{{ (int)$coupon->max_uses > 0 ? (int)$coupon->max_uses : '∞' }}</span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-3 text-muted fw-bold"><i class="fas fa-calendar-check me-1"></i>Ngày bắt đầu</div>
            <div class="col-sm-9">
              @if($coupon->starts_at)
                <i class="fas fa-calendar-check me-1 text-success"></i>{{ $coupon->starts_at->format('d/m/Y H:i') }}
              @else
                <span class="text-muted">Không giới hạn</span>
              @endif
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-3 text-muted fw-bold"><i class="fas fa-calendar-times me-1"></i>Ngày kết thúc</div>
            <div class="col-sm-9">
              @if($coupon->ends_at)
                <i class="fas fa-calendar-times me-1 text-danger"></i>{{ $coupon->ends_at->format('d/m/Y H:i') }}
              @else
                <span class="text-muted">Không giới hạn</span>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3 text-muted fw-bold"><i class="fas fa-toggle-on me-1"></i>Trạng thái</div>
            <div class="col-sm-9">
              @php $effective = method_exists($coupon,'isActiveNow') ? $coupon->isActiveNow() : (bool)$coupon->active; @endphp
              <span class="badge badge-pill fw-bold {{ $effective ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                {{ $effective ? 'Đang hiệu lực' : 'Không hiệu lực' }}
              </span>
              <div class="small text-muted mt-1">Bật: {{ $coupon->active ? 'Có' : 'Không' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Trạng thái sử dụng -->
    <div class="col-lg-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-line me-2"></i>Trạng thái sử dụng</h6>
        </div>
        <div class="card-body text-center">
          @php $effective = method_exists($coupon,'isActiveNow') ? $coupon->isActiveNow() : (bool)$coupon->active; @endphp
          @if($effective)
            <div class="text-success mb-3"><i class="fas fa-check-circle fa-3x"></i></div>
            <h5 class="text-success">Đang hoạt động</h5>
            <p class="text-muted mb-0">Mã có thể dùng trong đơn hợp lệ.</p>
          @else
            <div class="text-secondary mb-3"><i class="fas fa-times-circle fa-3x"></i></div>
            <h5 class="text-secondary">Không hoạt động</h5>
            <p class="text-muted mb-0">Hết hạn, vượt giới hạn, hoặc đang tắt.</p>
          @endif
        </div>
      </div>

      <!-- Thao tác nhanh -->
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bolt me-2"></i>Thao tác nhanh</h6>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="{{ route('admin.coupons.edit',$coupon) }}" class="btn btn-warning"><i class="fas fa-edit me-1"></i>Chỉnh sửa</a>
            <form action="{{ route('admin.coupons.destroy',$coupon) }}" method="post" onsubmit="return confirm('Bạn có chắc muốn xóa mã giảm giá này?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger w-100"><i class="fas fa-trash me-1"></i>Xóa mã giảm giá</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
