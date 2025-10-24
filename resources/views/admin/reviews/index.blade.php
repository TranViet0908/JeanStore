@extends('layouts.admin')
@section('title','Quản lý đánh giá')
@section('page-title','Quản lý đánh giá')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Đánh giá</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800">
        <i class="fas fa-star me-2"></i>Quản lý đánh giá
      </h1>
      <p class="text-muted">Theo dõi và quản lý các đánh giá sản phẩm từ khách hàng</p>
    </div>
    <div>
      <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tạo đánh giá mới
      </a>
    </div>
  </div>

  <!-- Filter Card -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fas fa-filter me-2"></i>Bộ lọc
      </h6>
    </div>
    <div class="card-body">
      <form class="row align-items-end" method="get">
        <div class="col-md-3 mb-2">
          <label class="form-label font-weight-bold">Tìm kiếm nội dung</label>
          <input type="text" name="q" class="form-control" placeholder="Nhập nội dung đánh giá..." value="{{ request('q') }}">
        </div>
        <div class="col-md-2 mb-2">
          <label class="form-label font-weight-bold">Đánh giá</label>
          <select name="rating" class="form-control">
            <option value="">-- Tất cả rating --</option>
            @for($i=5;$i>=1;$i--)
            <option value="{{ $i }}" @selected(request('rating')==$i)>{{ $i }} sao</option>
            @endfor
          </select>
        </div>
        <div class="col-md-2 mb-2">
          <label class="form-label font-weight-bold">Trạng thái duyệt</label>
          <select name="is_approved" class="form-control">
            <option value="">-- Tất cả trạng thái --</option>
            <option value="1" @selected(request('is_approved')==='1')>Đã duyệt</option>
            <option value="0" @selected(request('is_approved')==='0')>Chưa duyệt</option>
          </select>
        </div>
        <div class="col-md-2 mb-2">
          <button type="submit" class="btn btn-info btn-block">
            <i class="fas fa-search me-2"></i>Lọc kết quả
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Reviews Table -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fas fa-list me-2"></i>Danh sách đánh giá
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th class="text-center">
                <i class="fas fa-hashtag me-1"></i>ID
              </th>
              <th>
                <i class="fas fa-box me-1"></i>Sản phẩm
              </th>
              <th>
                <i class="fas fa-user me-1"></i>Người dùng
              </th>
              <th class="text-center">
                <i class="fas fa-star me-1"></i>Đánh giá
              </th>
              <th class="text-center">
                <i class="fas fa-check-circle me-1"></i>Trạng thái
              </th>
              <th>
                <i class="fas fa-comment me-1"></i>Nội dung
              </th>
              <th class="text-center">
                <i class="fas fa-cogs me-1"></i>Thao tác
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $r)
            <tr>
              <td class="text-center font-weight-bold">#{{ $r->id }}</td>
              <td>
                <div class="d-flex flex-column">
                  <span class="font-weight-bold text-primary">#{{ $r->product_id }}</span>
                  <small class="text-muted">{{ $r->product->name ?? 'Sản phẩm không tồn tại' }}</small>
                </div>
              </td>
              <td>
                <div class="d-flex flex-column">
                  <span class="font-weight-bold">#{{ $r->user_id }}</span>
                  <small class="text-muted">{{ $r->user->full_name ?? $r->user->name ?? 'Người dùng không tồn tại' }}</small>
                </div>
              </td>
              <td class="text-center">
                <div class="d-flex align-items-center justify-content-center">
                  <span class="badge badge-warning badge-pill font-weight-bold text-dark">
                    <i class="fas fa-star me-1"></i>{{ $r->rating }}/5
                  </span>
                </div>
              </td>
              <td class="text-center">
                <span class="badge badge-pill font-weight-bold {{ $r->is_approved ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                  @if($r->is_approved)
                  <i class="fas fa-check me-1"></i>Đã duyệt
                  @else
                  <i class="fas fa-clock me-1"></i>Chờ duyệt
                  @endif
                </span>
              </td>
              <td>
                <div class="text-truncate" style="max-width: 300px;" title="{{ $r->content }}">
                  {{ Str::limit($r->content, 60) }}
                </div>
              </td>
              <td class="text-center">
                <div class="btn-group" role="group">
                  <a href="{{ route('admin.reviews.show',$r) }}"
                    class="btn btn-sm btn-info"
                    title="Xem chi tiết">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.reviews.edit',$r) }}"
                    class="btn btn-sm btn-warning"
                    title="Chỉnh sửa">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.reviews.destroy',$r) }}"
                    method="post"
                    class="d-inline"
                    onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                      class="btn btn-sm btn-danger"
                      title="Xóa">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4">
                <div class="text-muted">
                  <i class="fas fa-inbox fa-3x mb-3"></i>
                  <p class="mb-0">Chưa có đánh giá nào</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Pagination -->
  @if($rows->hasPages())
  <div class="d-flex justify-content-center mt-4">
    {{ $rows->links() }}
  </div>
  @endif
</div>
@endsection