@extends('layouts.admin')

@section('title', 'Thêm danh mục mới - BanQuanJeans')
@section('page-title', 'Thêm danh mục mới')

@section('content')
<div class="container-fluid">
    <!-- Chuyển từ Tailwind sang Bootstrap classes -->
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.categories.index') }}">Danh mục</a>
            </li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="h3 font-weight-bold text-dark mb-2">Thêm danh mục mới</h1>
                <p class="text-muted">Tạo danh mục mới cho sản phẩm quần jeans</p>
            </div>

            <!-- Form Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus-circle me-2"></i>Thông tin danh mục
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label font-weight-bold">
                                <i class="fas fa-tag me-1"></i>
                                Tên danh mục 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   placeholder="Ví dụ: Jeans Nam, Jeans Nữ, Jeans Trẻ em..."
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Tên danh mục nên ngắn gọn và dễ hiểu
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu danh mục
                            </button>
                            <a href="{{ route('admin.categories.index') }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-4 border-info">
                <div class="card-body">
                    <h6 class="card-title text-info">
                        <i class="fas fa-lightbulb me-2"></i>Gợi ý
                    </h6>
                    <ul class="mb-0 text-muted">
                        <li>Tên danh mục nên rõ ràng và dễ hiểu</li>
                        <li>Tránh tạo quá nhiều danh mục con</li>
                        <li>Sử dụng tên tiếng Việt có dấu để thân thiện với khách hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
