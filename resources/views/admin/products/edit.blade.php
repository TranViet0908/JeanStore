@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm - BanQuanJeans')
@section('page-title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container-fluid">
    <!-- Chuyển từ Tailwind sang Bootstrap layout -->
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Chỉnh sửa sản phẩm</h1>
            <p class="text-muted">Cập nhật thông tin sản phẩm: <strong>{{ $product->name }}</strong></p>
        </div>
    </div>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin sản phẩm</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">
                                Tên sản phẩm <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id" class="font-weight-bold">
                                Danh mục <span class="text-danger">*</span>
                            </label>
                            <select id="category_id" 
                                    name="category_id" 
                                    class="form-control @error('category_id') is-invalid @enderror"
                                    required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="font-weight-bold">
                                        Giá (VNĐ) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price', $product->price) }}"
                                           class="form-control @error('price') is-invalid @enderror"
                                           min="0"
                                           required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock" class="font-weight-bold">
                                        Số lượng tồn kho <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           id="stock" 
                                           name="stock" 
                                           value="{{ old('stock', $product->stock) }}"
                                           class="form-control @error('stock') is-invalid @enderror"
                                           min="0"
                                           required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Mô tả sản phẩm</label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="6"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($product->image_url)
                        <div class="form-group">
                            <label class="font-weight-bold">Hình ảnh hiện tại</label>
                            <div class="mb-2">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-thumbnail"
                                     style="max-width: 200px; max-height: 200px;">
                            </div>
                            <small class="text-muted">Chọn ảnh mới để thay thế</small>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="image" class="font-weight-bold">
                                {{ $product->image_url ? 'Cập nhật hình ảnh' : 'Hình ảnh sản phẩm' }}
                            </label>
                            <div class="custom-file">
                                <input type="file" 
                                       class="custom-file-input @error('image') is-invalid @enderror" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*" 
                                       onchange="previewImage(event)">
                                <label class="custom-file-label" for="image">Chọn ảnh mới từ máy tính</label>
                            </div>
                            <small class="form-text text-muted">PNG, JPG, GIF tối đa 10MB</small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            
                            <!-- New Image Preview -->
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <img id="preview-img" src="/placeholder.svg" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Cập nhật sản phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript để preview ảnh -->
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const label = event.target.nextElementSibling;
    
    if (file) {
        label.textContent = file.name;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        label.textContent = 'Chọn ảnh mới từ máy tính';
        document.getElementById('image-preview').style.display = 'none';
    }
}
</script>
@endsection
