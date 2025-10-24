@extends('home')

@section('title', 'Live Chat')

@section('content')
@php $cid = $chat->id; @endphp

<div class="w-full bg-gradient-to-r from-slate-900 to-indigo-800">
  <div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white">Live Chat</h1>
    <p class="text-indigo-200 mt-1">Trao đổi trực tiếp về sản phẩm jeans, size, đổi trả.</p>
  </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-8">
  <div class="rounded-2xl shadow ring-1 ring-slate-200 overflow-hidden">
    <div id="chatBox" class="h-96 overflow-y-auto p-4 bg-slate-50"></div>

    <form id="chatForm" class="border-t bg-white p-3 flex gap-2">
      @csrf
      <input type="text" id="chatInput" name="body" class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Nhập tin nhắn..." required>
      <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">Gửi</button>
    </form>
  </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
const box = document.getElementById('chatBox');
const input = document.getElementById('chatInput');
const form = document.getElementById('chatForm');

function esc(s){return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;');}

function render(messages) {
  box.innerHTML = '';
  if (!messages || !messages.length) {
    box.innerHTML = '<p class="text-slate-500">Bắt đầu cuộc trò chuyện…</p>';
    return;
  }
  messages.forEach(m => {
    const mine = m.from === 'user';
    const wrap = document.createElement('div');
    wrap.className = 'mb-2 flex ' + (mine ? 'justify-end' : 'justify-start');
    wrap.innerHTML = `
      <div class="max-w-[75%] px-3 py-2 rounded-2xl ${mine ? 'bg-indigo-600 text-white' : 'bg-white ring-1 ring-slate-200'}">
        <div class="text-sm">${esc(m.body)}</div>
        <div class="text-[11px] opacity-70 mt-1">${esc(m.at)}</div>
      </div>`;
    box.appendChild(wrap);
  });
  box.scrollTop = box.scrollHeight;
}

async function poll() {
  try {
    const res = await fetch('{{ route('support.live_chat.poll') }}', {credentials:'same-origin'});
    if (!res.ok) return;
    const data = await res.json();
    render(data.messages || []);
  } catch(e) {}
}

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const body = input.value.trim();
  if (!body) return;
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const res = await fetch('{{ route('support.live_chat.send') }}', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN': token},
    body: JSON.stringify({body})
  });
  if (res.ok) { input.value=''; poll(); }
});

poll();
setInterval(poll, 2000);
</script>
@endsection
