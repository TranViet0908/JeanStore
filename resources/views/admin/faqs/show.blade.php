@extends('layouts.admin')
@section('title','Chi tiết FAQ')
@section('page-title','Chi tiết FAQ')

@section('content')
@php $faq = $faq ?? $row ?? null; @endphp
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQ</a></li>
      <li class="breadcrumb-item active">FAQ #{{ $faq?->id }}</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-question-circle me-2"></i>FAQ #{{ $faq?->id }}</h1>
      <p class="text-muted mb-0">Chi tiết câu hỏi</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.faqs.edit',$faq) }}" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a>
      <form action="{{ route('admin.faqs.destroy',$faq) }}" method="post" onsubmit="return confirm('Xóa FAQ này?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash me-2"></i>Xóa</button>
      </form>
      <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
    </div>
  </div>

  <!-- Details -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Thông tin chung</h6>
    </div>
    <div class="card-body">
      @php
        $active = (bool)$faq?->is_active;
        $cls = $active ? 'badge bg-success' : 'badge bg-secondary';
        $txt = $active ? 'Hiển thị' : 'Ẩn';
        $icon = $active ? 'fa-eye' : 'fa-eye-slash';
      @endphp
      <div class="row g-3">
        <div class="col-md-6">
          <div class="mb-2"><span class="text-muted">Mã:</span> <strong>#{{ $faq?->id }}</strong></div>
          <div class="mb-2"><span class="text-muted">Trạng thái:</span>
            <span class="{{ $cls }} rounded-pill px-3 ms-1"><i class="fas {{ $icon }} me-1"></i>{{ $txt }}</span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-2 text-muted"><i class="fas fa-calendar-plus me-1"></i>Tạo: {{ $faq?->created_at?->format('d/m/Y H:i') }}</div>
          <div class="mb-2 text-muted"><i class="fas fa-calendar-check me-1"></i>Cập nhật: {{ ($faq?->updated_at ?? $faq?->created_at)?->format('d/m/Y H:i') }}</div>
        </div>
        <div class="col-12">
          <div class="mb-2"><span class="text-muted">Câu hỏi:</span> <strong>{{ $faq?->question }}</strong></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Answer -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-align-left me-2"></i>Câu trả lời</h6>
    </div>
    <div class="card-body">
      @if(!empty($faq?->answer))
        <div>{!! $faq->answer !!}</div>
      @else
        <div class="text-muted">Chưa có nội dung trả lời.</div>
      @endif
    </div>
  </div>
</div>
@endsection
