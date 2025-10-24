@extends('layouts.admin')
@section('title','Chỉnh sửa người dùng')
@section('page-title','Chỉnh sửa người dùng')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Người dùng</a></li>
      <li class="breadcrumb-item active" aria-current="page">#{{ $user->id }}</li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-lg-7">
      <div class="card shadow-sm">
        <div class="card-body">
          <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
              <label class="form-label">Họ tên</label>
              <input type="text" name="full_name" value="{{ old('full_name', $user->full_name ?? ($user->name ?? '')) }}" class="form-control" required>
              @error('full_name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
              @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Vai trò</label>
                <select name="role" class="form-select" required>
                  @foreach(['admin'=>'Admin','staff'=>'Staff','user'=>'User'] as $val=>$text)
                    <option value="{{ $val }}" @selected(old('role', $user->role)===$val)>{{ $text }}</option>
                  @endforeach
                </select>
                @error('role')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="mb-3 mt-3">
              <label class="form-label">Địa chỉ</label>
              <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
              @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="password" class="form-control" placeholder="Để trống nếu không đổi">
                @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu">
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Cập nhật</button>
              <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card bg-light">
        <div class="card-body">
          <h6 class="card-title"><i class="fas fa-info-circle text-info me-1"></i>Thông tin</h6>
          <p class="mb-1"><strong>ID:</strong> #{{ $user->id }}</p>
          <p class="mb-1"><strong>Tạo lúc:</strong> {{ $user->created_at?->format('d/m/Y H:i') }}</p>
          <p class="mb-0"><strong>Cập nhật:</strong> {{ $user->updated_at?->format('d/m/Y H:i') }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
