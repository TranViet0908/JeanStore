@extends('layouts.admin')

@section('title', 'Chi tiết danh mục - BanQuanJeans')
@section('page-title', 'Chi tiết danh mục')

@section('content')
<div class="container-fluid">
    <!-- Tạo trang chi tiết với thiết kế bảng thông tin -->
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
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Category Details -->
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 font-weight-bold text-dark mb-2">{{ $category->name }}</h1>
                    <p class="text-muted">Chi tiết thông tin danh mục</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Chỉnh sửa
                    </a>
                    <button type="button" 
                            class="btn btn-danger"
                            onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i>Xóa
                    </button>
                </div>
            </div>

            <!-- Category Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Thông tin chi tiết
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold" style="width: 150px;">
                                        <i class="fas fa-hashtag text-muted me-2"></i>ID:
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">#{{ $category->id }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-tag text-muted me-2"></i>Tên danh mục:
                                    </td>
                                    <td class="h5 mb-0">{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-calendar-plus text-muted me-2"></i>Ngày tạo:
                                    </td>
                                    <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-calendar-edit text-muted me-2"></i>Cập nhật lần cuối:
                                    </td>
                                    <td>{{ $category->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-box text-muted me-2"></i>Số sản phẩm:
                                    </td>
                                    <td>
                                        <span class="badge bg-info fs-6">{{ $category->products_count ?? 0 }} sản phẩm</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Products in Category -->
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Sản phẩm trong danh mục
                    </h6>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Thêm sản phẩm
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($category->products) && $category->products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Tồn kho</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->products as $product)
                                        <tr>
                                            <td>
                                                @if($product->image_url)
                                                    <img src="{{ $product->image_url }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="rounded" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ number_format($product->price) }}đ</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                <span class="badge bg-success">Hoạt động</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open text-muted mb-3" style="font-size: 3rem;"></i>
                            <h6 class="text-muted">Chưa có sản phẩm nào trong danh mục này</h6>
                            <p class="text-muted mb-3">Hãy thêm sản phẩm đầu tiên cho danh mục này</p>
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Thêm sản phẩm
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>Thao tác nhanh
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa danh mục
                        </a>
                        <a href="#" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                        </a>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="btn btn-secondary">
                            <i class="fas fa-list me-2"></i>Danh sách danh mục
                        </a>
                        <button type="button" 
                                class="btn btn-danger"
                                onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Xóa danh mục
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Thống kê
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary">{{ $category->products_count ?? 0 }}</h4>
                                <small class="text-muted">Sản phẩm</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">0</h4>
                            <small class="text-muted">Đã bán</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden delete form -->
    <form id="delete-form" 
          action="{{ route('admin.categories.destroy', $category) }}" 
          method="POST" 
          class="d-none">
        @csrf
        @method('DELETE')
    </form>
</div>

<!-- Thêm JavaScript cho confirm delete -->
<script>
function confirmDelete() {
    if (confirm(`Bạn có chắc muốn xóa danh mục "${{'{{ $category->name }}'}}"?\n\nHành động này không thể hoàn tác và sẽ ảnh hưởng đến các sản phẩm trong danh mục.`)) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection
