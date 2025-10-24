@extends('layouts.admin')
@section('title','Quản lý Livechats')
@section('page-title','Quản lý Livechats')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Livechats</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-comments me-2"></i>Quản lý Livechats</h1>
      <p class="text-muted mb-0">Danh sách phiên chat trực tuyến</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.livechats.index') }}" class="btn btn-light border"><i class="fas fa-sync-alt me-2"></i>Làm mới</a>
      <a href="{{ route('admin.livechats.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tạo phiên chat</a>
    </div>
  </div>

  <!-- Filter -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter me-2"></i>Bộ lọc</h6>
      <a href="{{ route('admin.livechats.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-undo me-1"></i>Xóa lọc</a>
    </div>
    <div class="card-body">
      <form class="row g-3 align-items-end" method="get">
        <div class="col-md-6">
          <label class="form-label fw-bold">Tìm kiếm</label>
          <input name="q" value="{{ request('q') }}" class="form-control"
                 placeholder="ID, guest token, tên/email khách, nội dung">
        </div>
        <div class="col-md-3">
          <label class="form-label fw-bold">Trạng thái</label>
          @php $st = request('status'); @endphp
          <select name="status" class="form-control">
            <option value="">-- Tất cả --</option>
            <option value="active"     {{ $st==='active'?'selected':'' }}>Active</option>
            <option value="ended"      {{ $st==='ended'?'selected':'' }}>Ended</option>
            <option value="abandoned"  {{ $st==='abandoned'?'selected':'' }}>Abandoned</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label fw-bold">User ID</label>
          <input name="user_id" value="{{ request('user_id') }}" class="form-control" placeholder="ID người dùng">
        </div>
        <div class="col-12 col-md-2">
          <button type="submit" class="btn btn-info w-100"><i class="fas fa-search me-2"></i>Lọc</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Table -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list me-2"></i>Danh sách phiên chat</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="thead-light">
            <tr>
              <th class="text-center" style="width:80px"><i class="fas fa-hashtag me-1"></i>ID</th>
              <th style="width:190px"><i class="fas fa-qrcode me-1"></i>Guest token</th>
              <th style="width:220px"><i class="fas fa-user me-1"></i>User</th>
              <th class="text-center" style="width:140px"><i class="fas fa-toggle-on me-1"></i>Status</th>
              <th class="text-center" style="width:160px"><i class="fas fa-play me-1"></i>Started</th>
              <th class="text-center" style="width:160px"><i class="fas fa-envelope me-1"></i>Last msg</th>
              <th class="text-center" style="width:160px"><i class="fas fa-stop me-1"></i>Ended</th>
              <th class="text-center" style="width:150px"><i class="fas fa-cogs me-1"></i>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $c)
            <tr>
              <td class="text-center fw-bold">#{{ $c->id }}</td>
              <td><span class="badge bg-light text-dark">{{ $c->guest_token ?? '—' }}</span></td>

              <td>{{ optional($c->user)->full_name ?? ($c->user_id ? '#'.$c->user_id : '—') }}</td>
              <td class="text-center">
                @php
                  $status = $c->status ?? null;
                  $sText = ['active'=>'Active','ended'=>'Ended','abandoned'=>'Abandoned'][$status] ?? ($status ?? '—');
                  $sClass = [
                    'active'=>'badge bg-success',
                    'ended'=>'badge bg-secondary',
                    'abandoned'=>'badge bg-warning text-dark',
                  ][$status] ?? 'badge bg-light text-dark';
                  $sIcon = [
                    'active'=>'fa-signal',
                    'ended'=>'fa-check',
                    'abandoned'=>'fa-user-slash',
                  ][$status] ?? 'fa-minus-circle';
                @endphp
                <span class="{{ $sClass }} rounded-pill px-3"><i class="fas {{ $sIcon }} me-1"></i>{{ $sText }}</span>
              </td>
              <td class="text-center text-muted"><small>{{ optional($c->started_at)->format('d/m/Y H:i') ?? '—' }}</small></td>
              <td class="text-center text-muted"><small>{{ optional($c->last_message_at)->format('d/m/Y H:i') ?? '—' }}</small></td>
              <td class="text-center text-muted"><small>{{ optional($c->ended_at)->format('d/m/Y H:i') ?? '—' }}</small></td>
              <td class="text-center">
                <div class="btn-group" role="group">
                  <a href="{{ route('admin.livechats.show',$c) }}" class="btn btn-sm btn-outline-info" title="Xem"><i class="fas fa-eye"></i></a>
                  <a href="{{ route('admin.livechats.edit',$c) }}" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('admin.livechats.destroy',$c) }}" method="post" class="d-inline" onsubmit="return confirm('Xóa phiên chat này?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa"><i class="fas fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="9" class="text-center py-4">
                <div class="text-muted"><i class="fas fa-comments fa-3x mb-3"></i><p class="mb-0">Chưa có phiên chat nào</p></div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  @if($rows->hasPages())
  <div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted small">Tổng {{ $rows->total() }} bản ghi</div>
    <div>{{ $rows->links() }}</div>
  </div>
  @endif
</div>
@endsection
