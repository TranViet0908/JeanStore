{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')
@section('title','Người dùng')
@section('page-title','Người dùng')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Người dùng</li>
        </ol>
    </nav>

    {{-- Thu nhỏ pagination --}}
    <style>
        .pagination { font-size:.825rem }
        .page-link{ padding:.25rem .5rem }
        .page-item{ margin:0 2px }
    </style>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tên, email, sđt">
                        <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">-- Vai trò --</option>
                        @foreach(['admin'=>'Admin','staff'=>'Staff','user'=>'User'] as $val=>$text)
                        <option value="{{ $val }}" @selected(request('role')===$val)>{{ $text }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Xác minh</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            <td><span class="badge bg-secondary">#{{ $u->id }}</span></td>
                            <td class="fw-semibold">{{ $u->full_name ?? ($u->name ?? '—') }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                <form action="{{ route('admin.users.change_role', $u) }}" method="POST" class="d-flex gap-2 align-items-center">
                                    @csrf @method('PATCH')
                                    <select name="role" class="form-select form-select-sm" style="width:140px">
                                        @foreach(['admin'=>'Admin','staff'=>'Staff','user'=>'User'] as $val=>$text)
                                        <option value="{{ $val }}" @selected($u->role===$val)>{{ $text }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-sync"></i></button>
                                </form>
                            </td>
                            <td>
                                @if(!empty($u->email_verified_at) || (method_exists($u,'hasVerifiedEmail') && $u->hasVerifiedEmail()))
                                <span class="badge bg-success">Đã xác minh</span>
                                @else
                                <span class="badge bg-warning text-dark">Chưa xác minh</span>
                                @endif
                            </td>
                            <td>
                                @if(($u->status ?? 'active')==='active')
                                <span class="badge bg-success">Hoạt động</span>
                                @else
                                <span class="badge bg-secondary">Khóa</span>
                                @endif
                            </td>
                            <td>{{ $u->created_at?->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit',$u) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-edit"></i></a>
                                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa người dùng này?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Không có người dùng</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($users,'links'))
        <div class="card-footer bg-white">
            {{ $users->onEachSide(1)->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
