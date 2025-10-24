@extends('layouts.admin')

@section('title', 'Danh mục sản phẩm - BanQuanJeans')
@section('page-title', 'Danh mục sản phẩm')

@section('content')
<div class="container-fluid">
    <!-- Thay đổi từ grid layout sang table layout với Bootstrap -->
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h1 class="h3 font-weight-bold text-dark mb-2">Quản lý danh mục</h1>
            <p class="text-muted">Quản lý các danh mục quần jeans của cửa hàng</p>
            <small class="text-info">
                <i class="fas fa-info-circle me-1"></i>
                Tổng: {{ $categories->count() }} danh mục
            </small>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="btn btn-primary mt-3 mt-md-0">
            <i class="fas fa-plus me-2"></i>Thêm danh mục
        </a>
    </div>

    <!-- Categories Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Danh sách danh mục
            </h6>
            <div class="d-flex align-items-center">
                <input type="text" class="form-control form-control-sm me-2" placeholder="Tìm kiếm danh mục..." style="width: 200px;">
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 font-weight-bold text-uppercase text-secondary" style="font-size: 0.75rem;">
                                    <i class="fas fa-hashtag me-1"></i>ID
                                </th>
                                <th class="border-0 font-weight-bold text-uppercase text-secondary" style="font-size: 0.75rem;">
                                    <i class="fas fa-tag me-1"></i>Tên danh mục
                                </th>
                                <th class="border-0 font-weight-bold text-uppercase text-secondary" style="font-size: 0.75rem;">
                                    <i class="fas fa-box me-1"></i>Số sản phẩm
                                </th>
                                <th class="border-0 font-weight-bold text-uppercase text-secondary" style="font-size: 0.75rem;">
                                    <i class="fas fa-calendar me-1"></i>Ngày tạo
                                </th>
                                <th class="border-0 font-weight-bold text-uppercase text-secondary text-center" style="font-size: 0.75rem;">
                                    <i class="fas fa-cogs me-1"></i>Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td class="align-middle">
                                        <span class="badge bg-secondary">#{{ $category->id }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-tag text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 font-weight-bold">{{ $category->name }}</h6>
                                                <small class="text-muted">Danh mục sản phẩm</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-info">
                                            {{ $category->products_count ?? 0 }} sản phẩm
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $category->created_at->format('d/m/Y') }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $category->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.show', $category) }}" 
                                               class="btn btn-outline-info btn-sm" 
                                               title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               class="btn btn-outline-warning btn-sm"
                                               title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Xóa"
                                                    onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Hidden delete form -->
                                        <form id="delete-form-{{ $category->id }}" 
                                              action="{{ route('admin.categories.destroy', $category) }}" 
                                              method="POST" 
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty state -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-folder-open text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-muted mb-3">Chưa có danh mục nào</h5>
                    <p class="text-muted mb-4">Hãy tạo danh mục đầu tiên cho cửa hàng của bạn</p>
                    <a href="{{ route('admin.categories.create') }}" 
                       class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm danh mục đầu tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Thêm JavaScript cho confirm delete -->
<script>
function confirmDelete(categoryId, categoryName) {
    if (confirm(`Bạn có chắc muốn xóa danh mục "${categoryName}"?\n\nHành động này không thể hoàn tác.`)) {
        document.getElementById('delete-form-' + categoryId).submit();
    }
}
</script>
@endsection
