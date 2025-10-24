@extends('layouts.admin')
@section('title','Quản lý mã giảm giá')
@section('page-title','Quản lý mã giảm giá')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Mã giảm giá</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-tags me-2"></i>Quản lý mã giảm giá</h1>
      <p class="text-muted">Tạo và quản lý các mã giảm giá cho khách hàng</p>
    </div>
    <div>
      <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tạo mã giảm giá mới
      </a>
    </div>
  </div>

  <!-- Filter -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter me-2"></i>Bộ lọc</h6>
    </div>
    <div class="card-body">
      <form class="row align-items-end" method="get">
        <div class="col-md-3 mb-2">
          <label class="form-label font-weight-bold">Trạng thái</label>
          <select name="active" class="form-control">
            <option value="">-- Tất cả --</option>
            <option value="1" @selected(request('active')==='1')>Đang bật</option>
            <option value="0" @selected(request('active')==='0')>Đang tắt</option>
          </select>
        </div>
        <div class="col-md-3 mb-2">
          <label class="form-label font-weight-bold">Mã</label>
          <input type="text" name="code" class="form-control" placeholder="Nhập mã..." value="{{ request('code') }}">
        </div>
        <div class="col-md-3 mb-2">
          <button type="submit" class="btn btn-info btn-block">
            <i class="fas fa-search me-2"></i>Lọc
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Table -->
  <div class="card shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list me-2"></i>Danh sách mã giảm giá</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th class="text-center"><i class="fas fa-hashtag me-1"></i>ID</th>
              <th><i class="fas fa-ticket-alt me-1"></i>Mã</th>
              <th class="text-right"><i class="fas fa-percentage me-1"></i>Loại & giá trị</th>
              <th class="text-center"><i class="fas fa-sliders-h me-1"></i>Điều kiện</th>
              <th class="text-center"><i class="fas fa-user-check me-1"></i>Lượt dùng</th>
              <th class="text-center"><i class="fas fa-calendar me-1"></i>Thời hạn</th>
              <th class="text-center"><i class="fas fa-toggle-on me-1"></i>Trạng thái</th>
              <th class="text-center"><i class="fas fa-cogs me-1"></i>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $c)
            <tr>
              <td class="text-center font-weight-bold">#{{ $c->id }}</td>

              <td>
                <span class="badge badge-info badge-pill font-weight-bold text-dark font-monospace">
                  <i class="fas fa-ticket-alt me-1"></i>{{ $c->code }}
                </span>
              </td>

              <td class="text-right font-weight-bold">
                @if($c->type === 'percent')
                  {{ number_format((int)$c->value,0,',','.') }}%
                @else
                  {{ number_format((int)$c->value,0,',','.') }}₫
                @endif
                <div class="text-muted small">({{ $c->type }})</div>
              </td>

              <td class="text-center">
                <div class="small">
                  <div>Đơn tối thiểu:
                    <strong>
                      {{ (int)$c->min_order_total > 0 ? number_format((int)$c->min_order_total,0,',','.') . '₫' : 'Không' }}
                    </strong>
                  </div>
                  <div>Giảm tối đa:
                    <strong>
                      {{ (int)$c->max_discount > 0 ? number_format((int)$c->max_discount,0,',','.') . '₫' : 'Không' }}
                    </strong>
                  </div>
                </div>
              </td>

              <td class="text-center">
                <span class="badge badge-light text-dark font-monospace">
                  {{ (int)$c->used }}/{{ (int)$c->max_uses > 0 ? (int)$c->max_uses : '∞' }}
                </span>
              </td>

              <td class="text-center">
                @if($c->starts_at || $c->ends_at)
                  <small class="text-muted">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ $c->starts_at ? $c->starts_at->format('d/m/Y H:i') : '—' }}
                    -
                    {{ $c->ends_at ? $c->ends_at->format('d/m/Y H:i') : '—' }}
                  </small>
                @else
                  <span class="text-muted">Không giới hạn</span>
                @endif
              </td>

              <td class="text-center">
                @php $effective = method_exists($c,'isActiveNow') ? $c->isActiveNow() : (bool)$c->active; @endphp
                <span class="badge badge-pill font-weight-bold {{ $effective ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                  {{ $effective ? 'Đang hiệu lực' : 'Không hiệu lực' }}
                </span>
                <div class="small text-muted mt-1">
                  Bật: {{ $c->active ? 'Có' : 'Không' }}
                </div>
              </td>

              <td class="text-center">
                <div class="btn-group" role="group">
                  <a href="{{ route('admin.coupons.show',$c) }}" class="btn btn-sm btn-info" title="Xem">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.coupons.edit',$c) }}" class="btn btn-sm btn-warning" title="Sửa">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.coupons.destroy',$c) }}" method="post" class="d-inline"
                        onsubmit="return confirm('Bạn có chắc muốn xóa mã giảm giá này?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-4">
                <div class="text-muted">
                  <i class="fas fa-inbox fa-3x mb-3"></i>
                  <p class="mb-0">Chưa có mã giảm giá nào</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  @if($rows->hasPages())
    <div class="d-flex justify-content-center mt-4">
      {{ $rows->links() }}
    </div>
  @endif
</div>
@endsection
