@extends('layouts.admin')

@section('title', 'Chỉnh sửa danh mục - BanQuanJeans')
@section('page-title', 'Chỉnh sửa danh mục')

@section('content')
<div class="container-fluid">
    <!-- Chuyển từ Tailwind sang Bootstrap và thêm breadcrumb -->
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
            <li class="breadcrumb-item active">Chỉnh sửa: {{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="h3 font-weight-bold text-dark mb-2">Chỉnh sửa danh mục</h1>
                <p class="text-muted">Cập nhật thông tin danh mục "{{ $category->name }}"</p>
            </div>

            <!-- Form Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-edit me-2"></i>Cập nhật thông tin
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="form-label font-weight-bold">
                                <i class="fas fa-tag me-1"></i>
                                Tên danh mục 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $category->name) }}"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   placeholder="Ví dụ: Jeans Nam, Jeans Nữ, Jeans Trẻ em..."
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Category Info -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-info-circle text-info me-1"></i>
                                            Thông tin danh mục
                                        </h6>
                                        <p class="card-text mb-1">
                                            <strong>ID:</strong> #{{ $category->id }}
                                        </p>
                                        <p class="card-text mb-1">
                                            <strong>Ngày tạo:</strong> {{ $category->created_at->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="card-text mb-0">
                                            <strong>Cập nhật:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-chart-bar text-success me-1"></i>
                                            Thống kê
                                        </h6>
                                        <p class="card-text mb-0">
                                            <strong>Số sản phẩm:</strong> 
                                            <span class="badge bg-primary">{{ $category->products_count ?? 0 }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Cập nhật danh mục
                            </button>
                            <a href="{{ route('admin.categories.show', $category) }}" 
                               class="btn btn-info">
                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                            </a>
                            <a href="{{ route('admin.categories.index') }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
