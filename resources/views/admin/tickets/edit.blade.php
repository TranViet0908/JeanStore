@extends('layouts.admin')
@section('title','Chỉnh sửa ticket')
@section('page-title','Chỉnh sửa ticket')

@section('content')
@php $model = $row ?? $ticket ?? $t ?? null; @endphp
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Tickets</a></li>
      <li class="breadcrumb-item active">Chỉnh sửa #{{ $model?->id }}</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-ticket-alt me-2"></i>Chỉnh sửa ticket</h1>
      <p class="text-muted mb-0">Cập nhật thông tin ticket</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.tickets.show',$model) }}" class="btn btn-light border"><i class="fas fa-eye me-2"></i>Xem</a>
      <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
    </div>
  </div>

  <!-- Form Card -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Thông tin ticket</h6>
    </div>
    <div class="card-body">
      <form method="post" action="{{ route('admin.tickets.update',$model) }}">
        @csrf @method('PUT')

        @if ($errors->any())
          <div class="alert alert-danger">
            <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-2"></i>Lỗi nhập liệu</div>
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
          </div>
        @endif

        <div class="row g-3">
          <!-- Code chỉ hiển thị -->
          <div class="col-md-3">
            <label class="form-label fw-bold">Code</label>
            <input class="form-control" value="{{ $model?->code ?? '—' }}" readonly>
          </div>

          <!-- User + guest info -->
          <div class="col-md-3">
            <label class="form-label fw-bold">User (nếu có)</label>
            <select name="user_id" class="form-control">
              <option value="">-- Khách vãng lai --</option>
              @foreach(($users ?? []) as $u)
                <option value="{{ $u->id }}" @selected(old('user_id',$model?->user_id)==$u->id)>
                  #{{ $u->id }} — {{ $u->full_name ?? $u->name }}
                </option>
              @endforeach
            </select>
            @error('user_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold">Requester name</label>
            <input name="requester_name" value="{{ old('requester_name',$model?->requester_name) }}" class="form-control">
            @error('requester_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold">Requester email</label>
            <input name="requester_email" value="{{ old('requester_email',$model?->requester_email) }}" class="form-control">
            @error('requester_email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>

          <!-- Chủ đề + nội dung -->
          <div class="col-12">
            <label class="form-label fw-bold">Chủ đề <span class="text-danger">*</span></label>
            <input type="text" name="subject" value="{{ old('subject',$model?->subject) }}" class="form-control" required>
            @error('subject')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <label class="form-label fw-bold">Nội dung</label>
            <textarea name="content" rows="6" class="form-control">{{ old('content',$model?->content) }}</textarea>
            @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>

          <!-- Ưu tiên, trạng thái, gán, order -->
          <div class="col-md-3">
            <label class="form-label fw-bold">Priority</label>
            @php $pr = old('priority',$model?->priority); @endphp
            <select name="priority" class="form-control">
              <option value="low"     {{ $pr==='low'?'selected':'' }}>Low</option>
              <option value="normal"  {{ $pr==='normal'?'selected':'' }}>Normal</option>
              <option value="high"    {{ $pr==='high'?'selected':'' }}>High</option>
              <option value="urgent"  {{ $pr==='urgent'?'selected':'' }}>Urgent</option>
            </select>
            @error('priority')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold">Status</label>
            @php $st = old('status',$model?->status ?? 'open'); @endphp
            <select name="status" class="form-control">
              <option value="open"             {{ $st==='open'?'selected':'' }}>Open</option>
              <option value="pending"          {{ $st==='pending'?'selected':'' }}>Pending</option>
              <option value="waiting_customer" {{ $st==='waiting_customer'?'selected':'' }}>Waiting customer</option>
              <option value="resolved"         {{ $st==='resolved'?'selected':'' }}>Resolved</option>
              <option value="closed"           {{ $st==='closed'?'selected':'' }}>Closed</option>
            </select>
            @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold">Assigned to</label>
            @php $assignees = $assignees ?? $users ?? []; @endphp
            <select name="assigned_to" class="form-control">
              <option value="">-- Chưa gán --</option>
              @foreach($assignees as $a)
                <option value="{{ $a->id }}" @selected(old('assigned_to',$model?->assigned_to)==$a->id)>
                  #{{ $a->id }} — {{ $a->full_name ?? $a->name }}
                </option>
              @endforeach
            </select>
            @error('assigned_to')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold">Order ID</label>
            <input type="number" name="order_id" value="{{ old('order_id',$model?->order_id) }}" class="form-control">
            @error('order_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>

          <!-- Thời điểm (chỉ hiển thị) -->
          <div class="col-md-3">
            <label class="form-label fw-bold">Last message at</label>
            <input class="form-control" value="{{ optional($model?->last_message_at)->format('d/m/Y H:i') ?? '—' }}" readonly>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold">Closed at</label>
            <input class="form-control" value="{{ optional($model?->closed_at)->format('d/m/Y H:i') ?? '—' }}" readonly>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-times me-2"></i>Hủy
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Lưu
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
