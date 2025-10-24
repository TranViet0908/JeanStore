@extends('layouts.admin')
@section('title','Quản lý Tickets')
@section('page-title','Quản lý Tickets')

@section('content')
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Tickets</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-ticket-alt me-2"></i>Quản lý Tickets</h1>
      <p class="text-muted mb-0">Danh sách yêu cầu hỗ trợ</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.tickets.index') }}" class="btn btn-light border">
        <i class="fas fa-sync-alt me-2"></i>Làm mới
      </a>
      <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tạo ticket
      </a>
    </div>
  </div>

  <!-- Filter Card -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter me-2"></i>Bộ lọc</h6>
      <a href="{{ route('admin.tickets.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-undo me-1"></i>Xóa lọc
      </a>
    </div>
    <div class="card-body">
      <form class="row g-3 align-items-end" method="get">
        <div class="col-md-5">
          <label class="form-label fw-bold">Tìm kiếm</label>
          <input name="q" value="{{ request('q') }}" class="form-control"
                 placeholder="Mã, code, chủ đề, tên/email requester, nội dung">
        </div>
        <div class="col-md-3">
          <label class="form-label fw-bold">Trạng thái</label>
          @php $st = request('status'); @endphp
          <select name="status" class="form-control">
            <option value="">-- Tất cả --</option>
            <option value="open"              {{ $st==='open'?'selected':'' }}>Open</option>
            <option value="pending"           {{ $st==='pending'?'selected':'' }}>Pending</option>
            <option value="waiting_customer"  {{ $st==='waiting_customer'?'selected':'' }}>Waiting customer</option>
            <option value="resolved"          {{ $st==='resolved'?'selected':'' }}>Resolved</option>
            <option value="closed"            {{ $st==='closed'?'selected':'' }}>Closed</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label fw-bold">Ưu tiên</label>
          @php $pr = request('priority'); @endphp
          <select name="priority" class="form-control">
            <option value="">-- Tất cả --</option>
            <option value="low"     {{ $pr==='low'?'selected':'' }}>Low</option>
            <option value="normal"  {{ $pr==='normal'?'selected':'' }}>Normal</option>
            <option value="high"    {{ $pr==='high'?'selected':'' }}>High</option>
            <option value="urgent"  {{ $pr==='urgent'?'selected':'' }}>Urgent</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-info w-100">
            <i class="fas fa-search me-2"></i>Lọc
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Table Card -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list me-2"></i>Danh sách Tickets</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="thead-light">
            <tr>
              <th class="text-center" style="width:80px"><i class="fas fa-hashtag me-1"></i>ID</th>
              <th style="width:140px"><i class="fas fa-qrcode me-1"></i>Code</th>
              <th><i class="fas fa-heading me-1"></i>Chủ đề</th>
              <th style="width:260px"><i class="fas fa-user me-1"></i>Requester</th>
              <th style="width:160px"><i class="fas fa-user-headset me-1"></i>Assigned</th>
              <th class="text-center" style="width:150px"><i class="fas fa-flag me-1"></i>Priority</th>
              <th class="text-center" style="width:190px"><i class="fas fa-toggle-on me-1"></i>Status</th>
              <th class="text-center" style="width:170px"><i class="fas fa-clock me-1"></i>Last Msg</th>
              <th class="text-center" style="width:150px"><i class="fas fa-cogs me-1"></i>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $t)
            <tr>
              <td class="text-center fw-bold">#{{ $t->id }}</td>
              <td><span class="badge bg-light text-dark">{{ $t->code ?? '—' }}</span></td>
              <td>
                <div class="d-flex align-items-start">
                  <i class="fas fa-ticket-alt me-2 text-primary mt-1"></i>
                  <div>
                    <a href="{{ route('admin.tickets.show',$t) }}" class="fw-bold text-dark text-decoration-none">
                      {{ \Illuminate\Support\Str::limit($t->subject ?? ('Ticket #'.$t->id), 100) }}
                    </a>
                    @if(!empty($t->content))
                      <div class="text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($t->content), 120) }}</div>
                    @endif
                  </div>
                </div>
              </td>
              <td>
                @php
                  $rqName  = $t->requester_name ?? optional($t->user)->full_name;
                  $rqEmail = $t->requester_email ?? optional($t->user)->email;
                @endphp
                <div class="fw-semibold">{{ $rqName ?? '—' }}</div>
                <div class="text-muted small">{{ $rqEmail ?? '' }}</div>
              </td>
              <td>{{ optional($t->assignee)->full_name ?? ($t->assigned_to ? '#'.$t->assigned_to : '—') }}</td>
              <td class="text-center">
                @php
                  $priority = $t->priority ?? null;
                  $pText = ['low'=>'Low','normal'=>'Normal','high'=>'High','urgent'=>'Urgent'][$priority] ?? ($priority ?? '—');
                  $pClass = [
                    'low'=>'badge bg-secondary',
                    'normal'=>'badge bg-info',
                    'high'=>'badge bg-warning text-dark',
                    'urgent'=>'badge bg-danger',
                  ][$priority] ?? 'badge bg-light text-dark';
                @endphp
                <span class="{{ $pClass }} rounded-pill px-3">{{ $pText }}</span>
              </td>
              <td class="text-center">
                @php
                  $status = $t->status ?? null;
                  $sText = [
                    'open'=>'Open','pending'=>'Pending','waiting_customer'=>'Waiting customer',
                    'resolved'=>'Resolved','closed'=>'Closed'
                  ][$status] ?? ($status ?? '—');
                  $sClass = [
                    'open'=>'badge bg-primary',
                    'pending'=>'badge bg-warning text-dark',
                    'waiting_customer'=>'badge bg-secondary',
                    'resolved'=>'badge bg-success',
                    'closed'=>'badge bg-dark',
                  ][$status] ?? 'badge bg-light text-dark';
                  $sIcon = [
                    'open'=>'fa-door-open',
                    'pending'=>'fa-hourglass-half',
                    'waiting_customer'=>'fa-clock',
                    'resolved'=>'fa-check-circle',
                    'closed'=>'fa-check-double',
                  ][$status] ?? 'fa-minus-circle';
                @endphp
                <span class="{{ $sClass }} rounded-pill px-3"><i class="fas {{ $sIcon }} me-1"></i>{{ $sText }}</span>
              </td>
              <td class="text-center text-muted">
                <small><i class="fas fa-clock me-1"></i>{{ optional($t->last_message_at)->format('d/m/Y H:i') ?? '—' }}</small>
              </td>
              <td class="text-center">
                <div class="btn-group" role="group">
                  <a href="{{ route('admin.tickets.show',$t) }}" class="btn btn-sm btn-outline-info" title="Xem"><i class="fas fa-eye"></i></a>
                  <a href="{{ route('admin.tickets.edit',$t) }}" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('admin.tickets.destroy',$t) }}" method="post" class="d-inline" onsubmit="return confirm('Xóa ticket này?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa"><i class="fas fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="9" class="text-center py-4">
                <div class="text-muted"><i class="fas fa-ticket-alt fa-3x mb-3"></i><p class="mb-0">Chưa có ticket nào</p></div>
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
