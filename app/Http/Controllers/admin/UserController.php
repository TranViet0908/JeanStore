<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $r)
    {
        $q = User::query();

        if ($s = $r->get('q')) {
            $q->where(function ($x) use ($s) {
                $x->where('full_name', 'like', "%$s%")   // sửa: full_name
                    ->orWhere('email', 'like', "%$s%")
                    ->orWhere('phone', 'like', "%$s%");
            });
        }
        if ($role = $r->get('role')) {
            $q->where('role', $role);
        }

        $users = $q->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        // chuyển password => password_hash
        $data['password_hash'] = $data['password'];
        unset($data['password'], $data['password_confirmation']);

        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'Tạo người dùng thành công');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password_hash'] = $data['password'];
        }
        unset($data['password'], $data['password_confirmation']);

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Đã xóa người dùng');
    }

    // Đổi role nhanh trên danh sách
    public function changeRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,staff,user']);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'Đã đổi vai trò');
    }
}
