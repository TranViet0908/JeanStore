@extends('layouts.admin')
@section('title','Tạo FAQ')
@section('page-title','Tạo FAQ')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQ</a></li>
      <li class="breadcrumb-item active">Tạo mới</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-question-circle me-2"></i>Tạo FAQ</h1>
      <p class="text-muted mb-0">Nhập thông tin câu hỏi</p>
    </div>
    <div>
      <a href="{{ route('admin.faqs.index') }}" class="btn btn-light border"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
    </div>
  </div>

  <!-- Form -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Thông tin FAQ</h6>
    </div>
    <div class="card-body">
      <form method="post" action="{{ route('admin.faqs.store') }}">
        @csrf

        @if ($errors->any())
          <div class="alert alert-danger">
            <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-2"></i>Lỗi nhập liệu</div>
            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif

        <div class="row g-3">
          <div class="col-12">
            <label class="form-label fw-bold">Câu hỏi <span class="text-danger">*</span></label>
            <input type="text" name="question" value="{{ old('question') }}" class="form-control" required>
            @error('question')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>

          <div class="col-12">
            <label class="form-label fw-bold">Trả lời <span class="text-danger">*</span></label>
            <textarea name="answer" rows="6" class="form-control" required>{{ old('answer') }}</textarea>
            @error('answer')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>

          <div class="col-12">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="is_active">Hiển thị</label>
            </div>
            @error('is_active')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary me-2"><i class="fas fa-times me-2"></i>Hủy</a>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
