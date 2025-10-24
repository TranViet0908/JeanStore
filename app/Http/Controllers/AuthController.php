<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($v->fails()) return back()->withErrors($v)->withInput();

        $user = \App\Models\User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $isAdmin  = method_exists($user, 'isAdmin') ? $user->isAdmin() : (($user->role ?? null) === 'admin');
        $verified = method_exists($user, 'hasVerifiedEmail') ? $user->hasVerifiedEmail() : !empty($user->email_verified_at);

        if (! $isAdmin && ! $verified) {
            return redirect()->route('verification.notice')
                ->with('notice', 'Vui lòng xác minh email để tiếp tục.');
        }

        return $isAdmin
            ? redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công')
            : redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:500',
        ]);
        if ($v->fails()) return back()->withErrors($v)->withInput();

        $user = User::create([
            'full_name'     => $request->full_name,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
            'role'          => 'customer',
            'phone'         => $request->phone,
            'address'       => $request->address,
        ]);

        event(new Registered($user));          // gửi mail verify
        Auth::login($user);
        $request->session()->regenerate();

        // Sau đăng ký đưa tới trang nhắc xác minh
        return redirect()->route('verification.notice')
            ->with('success', 'Đăng ký thành công. Hãy xác minh email để tiếp tục.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Đăng xuất thành công!');
    }
}
