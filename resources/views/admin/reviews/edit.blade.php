@extends('layouts.admin')
@section('title','Chỉnh sửa đánh giá #'.$review->id)
@section('page-title','Chỉnh sửa đánh giá #'.$review->id)

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Đánh giá</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.reviews.show', $review) }}">Đánh giá #{{ $review->id }}</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Chỉnh sửa đánh giá #{{ $review->id }}</h1>
            <p class="text-muted">Cập nhật thông tin đánh giá sản phẩm</p>
        </div>
        <div>
            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i>Xem chi tiết
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Cập nhật thông tin đánh giá
                    </h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.reviews.update',$review) }}">
                        @csrf @method('PUT')
                        
                        <!-- Product & User Selection -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-box me-2 text-primary"></i>Sản phẩm
                                    </label>
                                    <select name="product_id" class="form-control form-control-lg" required>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}" @selected($p->id==$review->product_id)>
                                                #{{ $p->id }} - {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-user me-2 text-success"></i>Người dùng
                                    </label>
                                    <select name="user_id" class="form-control form-control-lg" required>
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}" @selected($u->id==$review->user_id)>
                                                #{{ $u->id }} - {{ $u->full_name ?? $u->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Rating & Approval Status -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-star me-2 text-warning"></i>Đánh giá (sao)
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <input type="number" name="rating" min="1" max="5" value="{{ $review->rating }}" class="form-control" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-star text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('rating')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-check-circle me-2 text-info"></i>Trạng thái duyệt
                                    </label>
                                    <div class="form-check form-check-lg mt-3">
                                        <input type="checkbox" name="is_approved" value="1" 
                                               class="form-check-input" id="is_approved"
                                               @checked($review->is_approved)>
                                        <label class="form-check-label font-weight-bold text-success" for="is_approved">
                                            Đã duyệt đánh giá này
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-comment-dots me-2 text-secondary"></i>Nội dung đánh giá
                            </label>
                            <textarea name="content" rows="5" class="form-control form-control-lg" placeholder="Nhập nội dung đánh giá...">{{ $review->content }}</textarea>
                            @error('content')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <button type="submit" class="btn btn-warning btn-lg btn-block">
                                            <i class="fas fa-save me-2"></i>Cập nhật đánh giá
                                        </button>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-lg btn-block">
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