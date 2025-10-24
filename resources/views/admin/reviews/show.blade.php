@extends('layouts.admin')
@section('title', 'Đánh giá #' . $review->id . ' - BanQuanJeans')
@section('page-title', 'Chi tiết đánh giá #' . $review->id)

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Đánh giá</a></li>
      <li class="breadcrumb-item active">Đánh giá #{{ $review->id }}</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800">
        <i class="fas fa-star me-2"></i>Đánh giá #{{ $review->id }}
      </h1>
      <p class="text-muted">Chi tiết thông tin đánh giá sản phẩm</p>
    </div>
    <div>
      <a href="{{ route('admin.reviews.edit',$review) }}" class="btn btn-warning me-2">
        <i class="fas fa-edit me-2"></i>Chỉnh sửa
      </a>
      <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
      </a>
    </div>
  </div>

  <div class="row">
    <!-- Review Status Card -->
    <div class="col-lg-4 mb-4">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-check-circle me-2"></i>Trạng thái đánh giá
          </h6>
        </div>
        <div class="card-body text-center">
          <div class="mb-3">
            @if($review->is_approved)
            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
            <h4 class="text-success">Đã duyệt</h4>
            @else
            <i class="fas fa-clock fa-4x text-warning mb-3"></i>
            <h4 class="text-warning">Chờ duyệt</h4>
            @endif
          </div>
          <div class="mb-2">
            @for($i = 1; $i <= 5; $i++)
              @if($i <= $review->rating)
                <i class="fas fa-star text-warning fa-lg"></i>
              @else
                <i class="far fa-star text-muted fa-lg"></i>
              @endif
            @endfor
          </div>
          <div class="h2 font-weight-bold text-primary mb-2">
            {{ $review->rating }}/5
          </div>
          <p class="text-muted mb-0">Điểm đánh giá</p>
        </div>
      </div>
    </div>

    <!-- Review Details -->
    <div class="col-lg-8 mb-4">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-info-circle me-2"></i>Thông tin chi tiết
          </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td class="font-weight-bold bg-light" width="30%">
                    <i class="fas fa-hashtag me-2 text-primary"></i>Mã đánh giá
                  </td>
                  <td class="font-weight-bold">#{{ $review->id }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-box me-2 text-info"></i>Sản phẩm
                  </td>
                  <td>
                    <a href="#" class="text-decoration-none">
                      #{{ $review->product_id }} - {{ $review->product->name ?? 'N/A' }}
                    </a>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-user me-2 text-success"></i>Người dùng
                  </td>
                  <td>
                    <a href="#" class="text-decoration-none">
                      #{{ $review->user_id }} - {{ $review->user->full_name ?? $review->user->name ?? 'N/A' }}
                    </a>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-star me-2 text-warning"></i>Đánh giá
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="h5 font-weight-bold text-warning mb-0 me-2">{{ $review->rating }}/5</span>
                      <div>
                        @for($i = 1; $i <= 5; $i++)
                          @if($i <= $review->rating)
                            <i class="fas fa-star text-warning"></i>
                          @else
                            <i class="far fa-star text-muted"></i>
                          @endif
                        @endfor
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-check-circle me-2 text-primary"></i>Trạng thái duyệt
                  </td>
                  <td>
                    <span class="badge badge-pill font-weight-bold
                                            @if($review->is_approved)
                                                bg-success text-white
                                            @else
                                                bg-warning text-dark
                                            @endif
                                        ">
                      @if($review->is_approved)
                      <i class="fas fa-check me-1"></i>Đã duyệt
                      @else
                      <i class="fas fa-clock me-1"></i>Chờ duyệt
                      @endif
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-calendar-plus me-2 text-muted"></i>Ngày tạo
                  </td>
                  <td>{{ $review->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold bg-light">
                    <i class="fas fa-calendar-edit me-2 text-muted"></i>Cập nhật lần cuối
                  </td>
                  <td>{{ $review->updated_at->format('d/m/Y H:i:s') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Review Content -->
  <div class="row">
    <div class="col-12 mb-4">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-comment-dots me-2"></i>Nội dung đánh giá
          </h6>
        </div>
        <div class="card-body">
          @if($review->content)
          <div class="bg-light p-4 rounded">
            <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 1.6;">{{ $review->content }}</p>
          </div>
          @else
          <div class="text-center text-muted py-4">
            <i class="fas fa-comment-slash fa-3x mb-3"></i>
            <p class="mb-0">Không có nội dung đánh giá</p>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-cogs me-2"></i>Thao tác
          </h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 mb-2">
              <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-warning btn-block">
                <i class="fas fa-edit me-2"></i>Chỉnh sửa đánh giá
              </a>
            </div>
            <div class="col-md-4 mb-2">
              <a href="{{ route('admin.reviews.index') }}" class="btn btn-info btn-block">
                <i class="fas fa-list me-2"></i>Danh sách đánh giá
              </a>
            </div>
            <div class="col-md-4 mb-2">
              <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline w-100">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="btn btn-danger btn-block"
                  onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                  <i class="fas fa-trash me-2"></i>Xóa đánh giá
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