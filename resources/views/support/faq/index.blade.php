@extends('home')

@section('title', 'Câu hỏi thường gặp')

@section('content')
<div class="w-full bg-gradient-to-r from-slate-900 to-indigo-800">
  <div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-white">Câu hỏi thường gặp</h1>
    <p class="text-indigo-200 mt-2">Giải đáp nhanh về đơn hàng, thanh toán, vận chuyển.</p>
  </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-8">
  <div class="space-y-4">
    @forelse($faqs as $f)
      <details class="group border rounded-xl bg-white shadow-sm">
        <summary class="flex items-center justify-between px-5 py-4 cursor-pointer select-none">
          <span class="font-medium text-slate-800">{{ $f->question }}</span>
          <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
          </svg>
        </summary>
        <div class="px-5 pb-5 pt-0 text-slate-700 border-t border-indigo-100">
          <div class="prose max-w-none">{!! nl2br(e($f->answer)) !!}</div>
        </div>
      </details>
    @empty
      <div class="text-slate-500">Chưa có mục FAQ.</div>
    @endforelse
  </div>
</div>
@endsection
