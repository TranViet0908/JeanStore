@extends('layouts.app')

@section('title', 'Xác minh email - BanQuanJeans')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-lg">
                <i class="fas fa-envelope-open text-2xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Xác minh email
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Vui lòng kiểm tra hộp thư để hoàn tất đăng ký
            </p>
        </div>

        <!-- Content Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <!-- Email Info -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-paper-plane text-blue-600"></i>
                </div>
                <p class="text-gray-700 mb-2">
                    Một email xác minh đã được gửi đến:
                </p>
                <p class="font-semibold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-lg inline-block">
                    {{ Auth::user()->email }}
                </p>
            </div>

            <!-- Instructions -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700">
                            Vui lòng kiểm tra hộp thư (bao gồm cả thư mục spam) và nhấp vào liên kết xác minh để kích hoạt tài khoản của bạn.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('message'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Resend Form -->
            <div class="space-y-4">
                <p class="text-center text-sm text-gray-600">
                    Chưa nhận được email?
                </p>
                
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-[1.02]">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Gửi lại email xác minh
                    </button>
                </form>

                <!-- Additional Actions -->
                <div class="flex items-center justify-center space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Quay lại đăng nhập
                    </a>
                    <span class="text-gray-300">|</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-red-600 transition-colors">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                Cần hỗ trợ? 
                <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">
                    Liên hệ với chúng tôi
                </a>
            </p>
        </div>
    </div>
</div>
@endsection