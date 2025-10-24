@extends('layouts.admin')

@section('title', $product->name . ' - BanQuanJeans')
@section('page-title', $product->name)

@section('content')
<div class="container-fluid">
    <!-- Chuyển từ Tailwind sang Bootstrap layout -->
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">{{ $product->name }}</h1>
            <p class="text-muted">Chi tiết sản phẩm</p>
        </div>
        <div>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Chỉnh sửa
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hình ảnh sản phẩm</h6>
                </div>
                <div class="card-body text-center">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded"
                             style="max-height: 400px;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                             style="height: 400px;">
                            <i class="fas fa-image fa-5x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin chi tiết</h6>
                </div>
                <div class="card-body">
                    <!-- Basic Info -->
                    <div class="mb-4">
                        <h2 class="h4 font-weight-bold text-gray-800 mb-3">{{ $product->name }}</h2>
                        <div class="d-flex align-items-center mb-3">
                            <span class="h3 font-weight-bold text-primary me-3">{{ number_format($product->price) }}đ</span>
                            @if($product->stock > 0)
                                <span class="badge badge-success">
                                    <i class="fas fa-box me-1"></i>Còn {{ $product->stock }} sản phẩm
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times me-1"></i>Hết hàng
                                </span>
                            @endif
                        </div>
                        <div class="mb-3">
                            @if($product->category)
                                <span class="badge badge-primary badge-pill">{{ $product->category->name }}</span>
                            @else
                                <span class="badge badge-secondary badge-pill">Chưa phân loại</span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    @if($product->description)
                    <div class="mb-4">
                        <h5 class="font-weight-bold text-gray-800 mb-2">Mô tả sản phẩm</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>
                    @endif

                    <!-- Product Details Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold bg-light" width="30%">Mã sản phẩm</td>
                                    <td>#{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold bg-light">Danh mục</td>
                                    <td>{{ $product->category ? $product->category->name : 'Chưa phân loại' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold bg-light">Giá bán</td>
                                    <td class="font-weight-bold text-primary">{{ number_format($product->price) }}đ</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold bg-light">Tồn kho</td>
                                    <td>
                                        @if($product->stock > 10)
                                            <span class="badge badge-success text-black-50">{{ $product->stock }} sản phẩm</span>
                                        @elseif($product->stock > 0)
                                            <span class="badge badge-warning">{{ $product->stock }} sản phẩm</span>
                                        @else
                                            <span class="badge badge-danger">{{ $product->stock }} sản phẩm</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold bg-light">Ngày tạo</td>
                                    <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold bg-light">Cập nhật lần cuối</td>
                                    <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thao tác</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-edit me-2"></i>Chỉnh sửa sản phẩm
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline w-100">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-block"
                                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                    <i class="fas fa-trash me-2"></i>Xóa sản phẩm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
