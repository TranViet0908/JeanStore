@extends('layouts.admin')
@section('title','Chi tiết phiên chat')
@section('page-title','Chi tiết phiên chat')

@section('content')
@php $model = $row ?? $livechat ?? $lc ?? null; @endphp
<div class="container-fluid">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.livechats.index') }}">Livechats</a></li>
      <li class="breadcrumb-item active">#{{ $model?->id }}</li>
    </ol>
  </nav>

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-comments me-2"></i>Phiên chat #{{ $model?->id }}</h1>
      <p class="text-muted mb-0">Chi tiết phiên chat</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.livechats.edit',$model) }}" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Chỉnh sửa</a>
      <form action="{{ route('admin.livechats.destroy',$model) }}" method="post" onsubmit="return confirm('Xóa phiên chat này?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash me-2"></i>Xóa</button>
      </form>
      <a href="{{ route('admin.livechats.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
    </div>
  </div>

  <!-- Details -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Thông tin chung</h6>
    </div>
    <div class="card-body">
      @php
        $status = $model?->status;
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

      <div class="row g-3">
        <div class="col-md-6">
          <div class="mb-2"><span class="text-muted">ID:</span> <strong>#{{ $model?->id }}</strong></div>
          <div class="mb-2"><span class="text-muted">Guest token:</span> <span class="badge bg-light text-dark">{{ $model?->guest_token ?? '—' }}</span></div>
          <div class="mb-2">
            <span class="text-muted">Trạng thái:</span>
            <span class="{{ $sClass }} rounded-pill px-3 ms-1"><i class="fas {{ $sIcon }} me-1"></i>{{ $sText }}</span>
          </div>
          <div class="mb-2 text-muted"><i class="fas fa-play me-1"></i>Started: {{ optional($model?->started_at)->format('d/m/Y H:i') ?? '—' }}</div>
          <div class="mb-2 text-muted"><i class="fas fa-envelope me-1"></i>Last msg: {{ optional($model?->last_message_at)->format('d/m/Y H:i') ?? '—' }}</div>
          <div class="mb-2 text-muted"><i class="fas fa-stop me-1"></i>Ended: {{ optional($model?->ended_at)->format('d/m/Y H:i') ?? '—' }}</div>
        </div>
        <div class="col-md-6">
          <div class="mb-2"><span class="text-muted">User:</span> <strong>{{ optional($model?->user)->full_name ?? ($model?->user_id ? '#'.$model?->user_id : '—') }}</strong></div>
          <div class="mb-2"><span class="text-muted">Guest:</span> <strong>{{ $model?->guest_name ?? '—' }}</strong></div>
          <div class="mb-2"><span class="text-muted">Email:</span> <strong>{{ $model?->guest_email ?? '—' }}</strong></div>
          <div class="mb-2 text-muted"><i class="fas fa-calendar-plus me-1"></i>Tạo: {{ optional($model?->created_at)->format('d/m/Y H:i') }}</div>
          <div class="mb-2 text-muted"><i class="fas fa-calendar-check me-1"></i>Cập nhật: {{ optional($model?->updated_at)->format('d/m/Y H:i') }}</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Messages -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-envelope me-2"></i>Tin nhắn</h6>
    </div>
    <div class="card-body">
      @php
        $msgs = is_array($model?->messages) ? $model->messages : json_decode($model?->messages ?? '[]', true);
      @endphp
      @if(is_array($msgs) && count($msgs))
        <ul class="list-unstyled mb-0">
          @foreach($msgs as $m)
            <li class="mb-3">
              <div class="d-flex">
                <div class="me-2">
                  <i class="fas {{ ($m['sender'] ?? '')==='agent' ? 'fa-user-headset text-primary' : 'fa-user text-secondary' }}"></i>
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between">
                    <strong>{{ $m['name'] ?? (($m['sender'] ?? '')==='agent' ? 'Agent' : 'Guest') }}</strong>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($m['time'] ?? $m['created_at'] ?? now())->format('d/m/Y H:i') }}</small>
                  </div>
                  <div>{!! nl2br(e($m['text'] ?? $m['content'] ?? '')) !!}</div>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <div class="text-muted">Chưa có tin nhắn.</div>
      @endif
    </div>
  </div>
</div>
@endsection
