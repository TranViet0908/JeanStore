@extends('layouts.admin')
@section('title','Chỉnh sửa mã giảm giá #'.$coupon->id)
@section('page-title','Chỉnh sửa mã giảm giá #'.$coupon->id)

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.coupons.show', $coupon) }}">Mã #{{ $coupon->id }}</a></li>
      <li class="breadcrumb-item active">Chỉnh sửa</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-edit me-2"></i>Chỉnh sửa mã giảm giá #{{ $coupon->id }}</h1>
      <p class="text-muted">Cập nhật <span class="badge badge-info font-monospace">{{ $coupon->code }}</span></p>
    </div>
    <div>
      <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-info me-2"><i class="fas fa-eye me-1"></i>Xem chi tiết</a>
      <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-ticket-alt me-2"></i>Thông tin mã giảm giá</h6>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('admin.coupons.update',$coupon) }}">
            @csrf @method('PUT')

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="code" class="form-label font-weight-bold"><i class="fas fa-code me-1"></i>Mã giảm giá *</label>
                <input type="text" name="code" id="code"
                  class="form-control @error('code') is-invalid @enderror"
                  placeholder="VD: SALE2025"
                  value="{{ old('code', $coupon->code) }}" maxlength="64" required>
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label for="type" class="form-label font-weight-bold"><i class="fas fa-exchange-alt me-1"></i>Loại giảm giá *</label>
                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                  <option value="percent" {{ old('type',$coupon->type)==='percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                  <option value="fixed"   {{ old('type',$coupon->type)==='fixed'   ? 'selected' : '' }}>Số tiền cố định</option>
                </select>
                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="discount" class="form-label font-weight-bold"><i class="fas fa-percentage me-1"></i>Giá trị giảm *</label>
                <input type="number" name="discount" id="discount"
                  class="form-control @error('discount') is-invalid @enderror"
                  placeholder="Nếu percent: 0–100. Nếu fixed: số tiền"
                  value="{{ old('discount', (int)$coupon->value) }}" min="0" step="1" required>
                @error('discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label for="max_discount" class="form-label font-weight-bold"><i class="fas fa-level-down-alt me-1"></i>Giảm tối đa</label>
                <input type="number" name="max_discount" id="max_discount"
                  class="form-control @error('max_discount') is-invalid @enderror"
                  placeholder="0 = không giới hạn"
                  value="{{ old('max_discount', (int)$coupon->max_discount) }}" min="0" step="1">
                @error('max_discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="max_uses" class="form-label font-weight-bold"><i class="fas fa-hashtag me-1"></i>Giới hạn lượt dùng</label>
                <input type="number" name="max_uses" id="max_uses"
                  class="form-control @error('max_uses') is-invalid @enderror"
                  placeholder="0 = không giới hạn"
                  value="{{ old('max_uses', (int)$coupon->max_uses) }}" min="0" step="1">
                @error('max_uses') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label font-weight-bold"><i class="fas fa-user-check me-1"></i>Đã dùng</label>
                <input type="number" class="form-control" value="{{ (int)$coupon->used }}" disabled>
              </div>

              <div class="col-md-4 mb-3">
                <label for="min_order_total" class="form-label font-weight-bold"><i class="fas fa-shopping-cart me-1"></i>Đơn tối thiểu</label>
                <input type="number" name="min_order_total" id="min_order_total"
                  class="form-control @error('min_order_total') is-invalid @enderror"
                  placeholder="0 = không yêu cầu"
                  value="{{ old('min_order_total', (int)$coupon->min_order_total) }}" min="0" step="1">
                @error('min_order_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="starts_at" class="form-label font-weight-bold"><i class="fas fa-calendar-alt me-1"></i>Ngày bắt đầu</label>
                <input type="datetime-local" name="starts_at" id="starts_at"
                  class="form-control @error('starts_at') is-invalid @enderror"
                  value="{{ old('starts_at', $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}">
                @error('starts_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label for="ends_at" class="form-label font-weight-bold"><i class="fas fa-calendar-times me-1"></i>Ngày kết thúc</label>
                <input type="datetime-local" name="ends_at" id="ends_at"
                  class="form-control @error('ends_at') is-invalid @enderror"
                  value="{{ old('ends_at', $coupon->ends_at ? $coupon->ends_at->format('Y-m-d\TH:i') : '') }}">
                @error('ends_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="mb-4">
              <div class="form-check form-switch">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                  class="form-check-input" {{ old('is_active', (bool)$coupon->active) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label font-weight-bold"><i class="fas fa-toggle-on me-1"></i>Kích hoạt mã giảm giá</label>
              </div>
              <small class="text-muted">Bật để cho phép dùng mã.</small>
            </div>

            <hr class="my-4">
            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('admin.coupons.show',$coupon) }}" class="btn btn-outline-secondary"><i class="fas fa-times me-1"></i>Hủy</a>
              <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Cập nhật</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
