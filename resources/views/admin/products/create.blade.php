@extends('layouts.admin')
@section('title','Tạo sản phẩm mới')
@section('page-title','Tạo sản phẩm mới')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
      <li class="breadcrumb-item active">Tạo mới</li>
    </ol>
  </nav>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-box me-2"></i>Thông tin sản phẩm
          </h6>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-4">
              <label class="form-label font-weight-bold">Tên sản phẩm</label>
              <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name') }}" required>
              @error('name') <div class="text-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mb-4">
              <label class="form-label font-weight-bold">Mô tả</label>
              <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
              @error('description') <div class="text-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-4">
                  <label class="form-label font-weight-bold">Giá (₫)</label>
                  <input type="number" step="0.01" name="price" class="form-control form-control-lg" value="{{ old('price') }}" required>
                  @error('price') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-4">
                  <label class="form-label font-weight-bold">Tồn kho</label>
                  <input type="number" name="stock" class="form-control form-control-lg" value="{{ old('stock', 0) }}" required>
                  @error('stock') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label font-weight-bold">Danh mục</label>
              <select name="category_id" class="form-control form-control-lg" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach(($categories ?? collect()) as $c)
                  <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
                @endforeach
              </select>
              @error('category_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mb-4">
              <label class="form-label font-weight-bold">Ảnh sản phẩm</label>
              <input type="file" name="image" class="form-control-file">
              @error('image') <div class="text-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="card bg-light">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      <i class="fas fa-save me-2"></i>Lưu sản phẩm
                    </button>
                  </div>
                  <div class="col-md-6 mb-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg btn-block">
                      <i class="fas fa-times me-2"></i>Hủy bỏ
                    </a>
                  </div>
                </div>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
