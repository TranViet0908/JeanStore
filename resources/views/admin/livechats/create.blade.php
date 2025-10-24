@extends('layouts.admin')
@section('title','Tạo phiên chat')
@section('page-title','Tạo phiên chat')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.livechats.index') }}">Livechats</a></li>
      <li class="breadcrumb-item active">Tạo mới</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-comments me-2"></i>Tạo phiên chat</h1>
      <p class="text-muted">Nhập thông tin phiên chat</p>
    </div>
    <div><a href="{{ route('admin.livechats.index') }}" class="btn btn-light border"><i class="fas fa-arrow-left me-2"></i>Quay lại</a></div>
  </div>

  <!-- Form -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Thông tin phiên chat</h6>
    </div>
    <div class="card-body">
      <form method="post" action="{{ route('admin.livechats.store') }}">
        @csrf

        @if ($errors->any())
          <div class="alert alert-danger">
            <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-2"></i>Lỗi nhập liệu</div>
            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif

        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-bold">User (nếu có)</label>
            <select name="user_id" class="form-control">
              <option value="">-- Khách vãng lai --</option>
              @foreach(($users ?? []) as $u)
                <option value="{{ $u->id }}" @selected(old('user_id')==$u->id)>#{{ $u->id }} — {{ $u->full_name ?? $u->name }}</option>
              @endforeach
            </select>
            @error('user_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label fw-bold">Guest name</label>
            <input name="guest_name" value="{{ old('guest_name') }}" class="form-control">
            @error('guest_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label fw-bold">Guest email</label>
            <input name="guest_email" value="{{ old('guest_email') }}" class="form-control">
            @error('guest_email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-4">
            <label class="form-label fw-bold">Status</label>
            @php $st = old('status','active'); @endphp
            <select name="status" class="form-control">
              <option value="active"    {{ $st==='active'?'selected':'' }}>Active</option>
              <option value="ended"     {{ $st==='ended'?'selected':'' }}>Ended</option>
              <option value="abandoned" {{ $st==='abandoned'?'selected':'' }}>Abandoned</option>
            </select>
            @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label fw-bold">Started at</label>
            <input type="datetime-local" name="started_at" value="{{ old('started_at') }}" class="form-control">
            @error('started_at')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label fw-bold">Guest token (tùy chọn)</label>
            <input name="guest_token" value="{{ old('guest_token') }}" class="form-control" placeholder="Để trống nếu hệ thống tự tạo">
            @error('guest_token')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <a href="{{ route('admin.livechats.index') }}" class="btn btn-outline-secondary me-2"><i class="fas fa-times me-2"></i>Hủy</a>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
