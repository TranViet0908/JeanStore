@extends('layouts.admin')
@section('title','Chi tiết ticket')
@section('page-title','Chi tiết ticket')

@section('content')
@php $model = $row ?? $ticket ?? $t ?? null; @endphp
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Tickets</a></li>
      <li class="breadcrumb-item active">#{{ $model?->id }}</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-ticket-alt me-2"></i>Ticket #{{ $model?->id }}</h1>
      <p class="text-muted mb-0">Chi tiết yêu cầu hỗ trợ</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.tickets.edit',$model) }}" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a>
      <form action="{{ route('admin.tickets.destroy',$model) }}" method="post" onsubmit="return confirm('Xóa ticket này?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash me-2"></i>Xóa</button>
      </form>
      <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
    </div>
  </div>

  <!-- Details Card -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Thông tin chung</h6>
    </div>
    <div class="card-body">
      @php
        $priority = $model?->priority;
        $pText = ['low'=>'Low','normal'=>'Normal','high'=>'High','urgent'=>'Urgent'][$priority] ?? ($priority ?? '—');
        $pClass = [
          'low'=>'badge bg-secondary',
          'normal'=>'badge bg-info',
          'high'=>'badge bg-warning text-dark',
          'urgent'=>'badge bg-danger',
        ][$priority] ?? 'badge bg-light text-dark';

        $status = $model?->status;
        $sText = ['open'=>'Open','pending'=>'Pending','waiting_customer'=>'Waiting customer','resolved'=>'Resolved','closed'=>'Closed'][$status] ?? ($status ?? '—');
        $sClass = [
          'open'=>'badge bg-primary',
          'pending'=>'badge bg-warning text-dark',
          'waiting_customer'=>'badge bg-secondary',
          'resolved'=>'badge bg-success',
          'closed'=>'badge bg-dark',
        ][$status] ?? 'badge bg-light text-dark';
        $sIcon = [
          'open'=>'fa-door-open','pending'=>'fa-hourglass-half','waiting_customer'=>'fa-clock','resolved'=>'fa-check-circle','closed'=>'fa-check-double',
        ][$status] ?? 'fa-minus-circle';

        $rqName  = $model?->requester_name ?? optional($model?->user)->full_name;
        $rqEmail = $model?->requester_email ?? optional($model?->user)->email;
      @endphp

      <div class="row g-3">
        <div class="col-md-6">
          <div class="mb-2"><span class="text-muted">Mã:</span> <strong>#{{ $model?->id }}</strong></div>
          <div class="mb-2"><span class="text-muted">Code:</span> <span class="badge bg-light text-dark">{{ $model?->code ?? '—' }}</span></div>
          <div class="mb-2"><span class="text-muted">Chủ đề:</span> <strong>{{ $model?->subject }}</strong></div>
          <div class="mb-2">
            <span class="text-muted">Trạng thái:</span>
            <span class="{{ $sClass }} rounded-pill px-3 ms-1"><i class="fas {{ $sIcon }} me-1"></i>{{ $sText }}</span>
          </div>
          <div class="mb-2">
            <span class="text-muted">Priority:</span>
            <span class="{{ $pClass }} rounded-pill px-3 ms-1">{{ $pText }}</span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-2"><span class="text-muted">Requester:</span> <strong>{{ $rqName ?? '—' }}</strong></div>
          <div class="mb-2"><span class="text-muted">Email:</span> <strong>{{ $rqEmail ?? '—' }}</strong></div>
          <div class="mb-2"><span class="text-muted">Assigned:</span> <strong>{{ optional($model?->assignee)->full_name ?? ($model?->assigned_to ? '#'.$model?->assigned_to : '—') }}</strong></div>
          <div class="mb-2"><span class="text-muted">Order ID:</span> <strong>{{ $model?->order_id ?? '—' }}</strong></div>
          <div class="mb-2 text-muted"><i class="fas fa-envelope me-1"></i>Last msg: {{ optional($model?->last_message_at)->format('d/m/Y H:i') ?? '—' }}</div>
          <div class="mb-2 text-muted"><i class="fas fa-calendar-plus me-1"></i>Tạo: {{ optional($model?->created_at)->format('d/m/Y H:i') }}</div>
          <div class="mb-2 text-muted"><i class="fas fa-calendar-check me-1"></i>Cập nhật: {{ optional($model?->updated_at)->format('d/m/Y H:i') }}</div>
          <div class="mb-2 text-muted"><i class="fas fa-lock me-1"></i>Closed at: {{ optional($model?->closed_at)->format('d/m/Y H:i') ?? '—' }}</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-align-left me-2"></i>Nội dung</h6>
    </div>
    <div class="card-body">
      @if(!empty($model?->content))
        <div class="mb-0">{!! nl2br(e($model->content)) !!}</div>
      @else
        <div class="text-muted">Chưa có nội dung.</div>
      @endif
    </div>
  </div>

  <!-- Conversation JSON (nếu có) -->
  @if(!empty($model?->conversation))
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-comments me-2"></i>Conversation</h6>
    </div>
    <div class="card-body">
      @php
        $conv = is_array($model->conversation) ? $model->conversation : json_decode($model->conversation ?? '[]', true);
      @endphp
      @if(is_array($conv) && count($conv))
        <pre class="mb-0" style="white-space:pre-wrap">{{ json_encode($conv, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
      @else
        <div class="text-muted">Không có dữ liệu hội thoại.</div>
      @endif
    </div>
  </div>
  @endif
</div>
@endsection
