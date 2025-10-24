@extends('layouts.admin')
@section('title','Quản lý FAQ')
@section('page-title','Quản lý FAQ')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">FAQ</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800">
        <i class="fas fa-question-circle me-2"></i>Quản lý FAQ
      </h1>
      <p class="text-muted mb-0">Câu hỏi thường gặp</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.faqs.index') }}" class="btn btn-light border">
        <i class="fas fa-sync-alt me-2"></i>Làm mới
      </a>
      <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tạo FAQ mới
      </a>
    </div>
  </div>

  <!-- Filter Card -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fas fa-filter me-2"></i>Bộ lọc
      </h6>
      <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-undo me-1"></i>Xóa lọc
      </a>
    </div>
    <div class="card-body">
      <form class="row g-3 align-items-end" method="get">
        <div class="col-md-6">
          <label class="form-label fw-bold">Tìm kiếm câu hỏi</label>
          <input name="q" value="{{ request('q') }}" placeholder="Nhập từ khóa..." class="form-control">
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn btn-info w-100">
            <i class="fas fa-search me-2"></i>Lọc kết quả
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Table -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fas fa-list me-2"></i>Danh sách FAQ
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="thead-light">
            <tr>
              <th class="text-center" style="width:90px"><i class="fas fa-hashtag me-1"></i>ID</th>
              <th><i class="fas fa-question me-1"></i>Câu hỏi</th>
              <th class="text-center" style="width:160px"><i class="fas fa-eye me-1"></i>Hiển thị</th>
              <th class="text-center" style="width:170px"><i class="fas fa-calendar me-1"></i>Ngày tạo</th>
              <th class="text-center" style="width:150px"><i class="fas fa-cogs me-1"></i>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $faq)
            <tr>
              <td class="text-center fw-bold">#{{ $faq->id }}</td>
              <td>
                <div class="d-flex align-items-start">
                  <i class="fas fa-question-circle me-2 text-primary mt-1"></i>
                  <div>
                    <a href="{{ route('admin.faqs.show',$faq) }}" class="fw-bold text-dark text-decoration-none">
                      {{ \Illuminate\Support\Str::limit($faq->question, 100) }}
                    </a>
                    @if($faq->answer)
                      <div class="text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($faq->answer), 120) }}</div>
                    @endif
                  </div>
                </div>
              </td>
              <td class="text-center">
                @php
                  $active = (bool)$faq->is_active;
                  $cls = $active ? 'badge bg-success' : 'badge bg-secondary';
                  $txt = $active ? 'Hiển thị' : 'Ẩn';
                  $icon = $active ? 'fa-eye' : 'fa-eye-slash';
                @endphp
                <span class="{{ $cls }} rounded-pill px-3">
                  <i class="fas {{ $icon }} me-1"></i>{{ $txt }}
                </span>
              </td>
              <td class="text-center text-muted">
                <small><i class="fas fa-calendar-alt me-1"></i>{{ $faq->created_at?->format('d/m/Y') }}</small>
              </td>
              <td class="text-center">
                <div class="btn-group" role="group">
                  <a href="{{ route('admin.faqs.show',$faq) }}" class="btn btn-sm btn-outline-info" title="Xem"><i class="fas fa-eye"></i></a>
                  <a href="{{ route('admin.faqs.edit',$faq) }}" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('admin.faqs.destroy',$faq) }}" method="post" class="d-inline" onsubmit="return confirm('Xóa FAQ này?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa"><i class="fas fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4">
                <div class="text-muted">
                  <i class="fas fa-question-circle fa-3x mb-3"></i>
                  <p class="mb-0">Chưa có FAQ nào</p>
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
  <div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted small">Tổng {{ $rows->total() }} bản ghi</div>
    <div>{{ $rows->links() }}</div>
  </div>
  @endif
</div>
@endsection
