@extends('home')

@section('title', 'Tạo ticket')

@section('content')
<div class="w-full bg-gradient-to-r from-slate-900 to-indigo-800">
  <div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white">Tạo ticket</h1>
    <p class="text-indigo-200 mt-1">Mô tả vấn đề về đơn hàng hoặc sản phẩm jeans.</p>
  </div>
</div>

<div class="max-w-xl mx-auto px-4 py-8">
  <form method="post" action="{{ route('support.tickets.store') }}" class="space-y-5 bg-white p-6 rounded-2xl shadow ring-1 ring-slate-200">
    @csrf
    <div>
      <label class="block text-sm mb-1 text-slate-700">Chủ đề</label>
      <input name="subject" value="{{ old('subject') }}" required
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      @error('subject')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="block text-sm mb-1 text-slate-700">Nội dung</label>
      <textarea name="content" rows="6" required
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('content') }}</textarea>
      @error('content')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-center gap-2">
      <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Gửi</button>
      <a href="{{ route('support.tickets.index') }}" class="px-4 py-2 text-slate-700 hover:underline">Hủy</a>
    </div>
  </form>
</div>
@endsection
