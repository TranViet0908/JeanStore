{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.admin')
@section('title','Thêm người dùng')
@section('page-title','Thêm người dùng')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.users.index') }}">Người dùng</a>
      </li>
      <li class="breadcrumb-item active">Thêm mới</li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-lg-7">
      <div class="card shadow-sm">
        <div class="card-body">
          <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label class="form-label">Họ tên</label>
              <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" required>
              @error('full_name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
              @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control" required>
              </div>
            </div>

            <div class="row g-3 mt-0">
              <div class="col-md-6">
                <label class="form-label">Vai trò</label>
                <select name="role" class="form-select">
                  @foreach(['admin'=>'Admin','staff'=>'Staff','user'=>'User'] as $val=>$text)
                    <option value="{{ $val }}" @selected(old('role')===$val)>{{ $text }}</option>
                  @endforeach
                </select>
                @error('role')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                  <option value="active"  @selected(old('status','active')==='active')>Hoạt động</option>
                  <option value="blocked" @selected(old('status')==='blocked')>Khóa</option>
                </select>
                @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="row g-3 mt-0">
              <div class="col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Lưu</button>
              <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card border-info">
        <div class="card-body">
          <h6 class="card-title text-info"><i class="fas fa-lightbulb me-2"></i>Gợi ý</h6>
          <ul class="mb-0 text-muted small">
            <li>Email duy nhất và hợp lệ</li>
            <li>Mật khẩu tối thiểu 8 ký tự</li>
            <li>Có thể mời người dùng xác minh email sau khi tạo</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
