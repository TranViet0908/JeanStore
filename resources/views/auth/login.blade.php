@extends('layouts.app')

@section('title', 'Đăng nhập - BanQuanJeans')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-lg">
                <i class="fas fa-user text-2xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Chào mừng trở lại
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Đăng nhập để mua sắm quần jeans yêu thích của bạn
            </p>
            <p class="mt-2 text-sm text-gray-600">
                Chưa có tài khoản?
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                    Đăng ký ngay
                </a>
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="block w-full pl-10 pr-3 py-3 border rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('email') border-red-500 @else border-gray-300 @enderror" 
                               placeholder="Nhập địa chỉ email của bạn" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mật khẩu
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="block w-full pl-10 pr-3 py-3 border rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('password') border-red-500 @else border-gray-300 @enderror" 
                               placeholder="Nhập mật khẩu của bạn">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-[1.02]">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Đăng nhập
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                Bằng cách đăng nhập, bạn đồng ý với
                <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">
                    Điều khoản dịch vụ
                </a>
                và
                <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">
                    Chính sách bảo mật
                </a>
            </p>
        </div>
    </div>
</div>
@endsection