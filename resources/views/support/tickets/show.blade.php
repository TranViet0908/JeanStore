@extends('home')

@section('title', 'Chi tiết ticket')

@section('content')
@php $conv = $ticket->conversation ?? []; @endphp

<div class="w-full bg-gradient-to-r from-slate-900 to-indigo-800">
  <div class="max-w-3xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between">
      <h1 class="text-3xl font-bold text-white">#{{ $ticket->code }}</h1>
      <span class="px-2 py-1 rounded text-sm bg-indigo-600 text-white capitalize">{{ $ticket->status }}</span>
    </div>
    <p class="text-indigo-200 mt-1">{{ $ticket->subject }}</p>
  </div>
</div>

<div class="max-w-3xl mx-auto px-4 py-8">
  <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-4 mb-4 max-h-[480px] overflow-y-auto">
    @forelse($conv as $m)
      @php $mine = ($m['from'] ?? '') === 'user'; @endphp
      <div class="mb-3 flex {{ $mine ? 'justify-end' : 'justify-start' }}">
        <div class="max-w-[75%] px-3 py-2 rounded-2xl {{ $mine ? 'bg-indigo-600 text-white' : 'bg-slate-50 ring-1 ring-slate-200' }}">
          <div class="text-sm">{!! isset($m['body']) ? nl2br(e($m['body'])) : '' !!}</div>
          <div class="text-[11px] opacity-70 mt-1">{{ $m['at'] ?? '' }}</div>
        </div>
      </div>
    @empty
      <p class="text-slate-500">Chưa có trao đổi.</p>
    @endforelse
  </div>

  <form method="post" action="{{ route('support.tickets.reply', $ticket->id) }}" class="flex gap-2">
    @csrf
    <input type="text" name="body" class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Nhập phản hồi..." required>
    <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Gửi</button>
  </form>
</div>
@endsection
