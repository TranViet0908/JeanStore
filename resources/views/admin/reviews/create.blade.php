@extends('layouts.admin')
@section('title','Tạo đánh giá mới')
@section('page-title','Tạo đánh giá mới')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Đánh giá</a></li>
      <li class="breadcrumb-item active">Tạo mới</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800">
        <i class="fas fa-plus-circle me-2"></i>Tạo đánh giá mới
      </h1>
      <p class="text-muted">Điền thông tin để tạo đánh giá sản phẩm</p>
    </div>
    <div>
      <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
      </a>
    </div>
  </div>

  <!-- Form Card -->
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-star me-2"></i>Thông tin đánh giá
          </h6>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('admin.reviews.store') }}">
            @csrf
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="product_id" class="form-label font-weight-bold">
                  <i class="fas fa-box me-1"></i>Sản phẩm *
                </label>
                <select name="product_id" 
                        id="product_id"
                        class="form-control @error('product_id') is-invalid @enderror" 
                        required>
                  <option value="">-- Chọn sản phẩm --</option>
                  @foreach($products as $p)
                  <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                    #{{ $p->id }} — {{ $p->name }}
                  </option>
                  @endforeach
                </select>
                @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="user_id" class="form-label font-weight-bold">
                  <i class="fas fa-user me-1"></i>Người dùng *
                </label>
                <select name="user_id" 
                        id="user_id"
                        class="form-control @error('user_id') is-invalid @enderror" 
                        required>
                  <option value="">-- Chọn người dùng --</option>
                  @foreach($users as $u)
                  <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                    #{{ $u->id }} — {{ $u->full_name ?? $u->name }}
                  </option>
                  @endforeach
                </select>
                @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="rating" class="form-label font-weight-bold">
                  <i class="fas fa-star me-1"></i>Đánh giá *
                </label>
                <select name="rating" 
                        id="rating"
                        class="form-control @error('rating') is-invalid @enderror" 
                        required>
                  @for($i = 1; $i <= 5; $i++)
                  <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>
                    {{ $i }} sao
                  </option>
                  @endfor
                </select>
                @error('rating')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3 d-flex align-items-end">
                <div class="form-check form-switch">
                  <input type="checkbox" 
                         name="is_approved" 
                         value="1" 
                         id="is_approved"
                         class="form-check-input" 
                         {{ old('is_approved') ? 'checked' : '' }}>
                  <label for="is_approved" class="form-check-label font-weight-bold">
                    <i class="fas fa-check-circle me-1"></i>Duyệt ngay
                  </label>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label for="content" class="form-label font-weight-bold">
                <i class="fas fa-comment me-1"></i>Nội dung đánh giá *
              </label>
              <textarea name="content" 
                        id="content"
                        rows="5" 
                        class="form-control @error('content') is-invalid @enderror" 
                        placeholder="Nhập nội dung đánh giá về sản phẩm..."
                        required>{{ old('content') }}</textarea>
              @error('content')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="text-muted">Chia sẻ cảm nhận và trải nghiệm về sản phẩm</small>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-1"></i>Hủy bỏ
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>Lưu đánh giá
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection