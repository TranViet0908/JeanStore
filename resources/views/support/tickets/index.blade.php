@extends('home')

@section('title', 'Yêu cầu hỗ trợ')

@section('content')
<div class="w-full bg-gradient-to-r from-slate-900 to-indigo-800">
  <div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white">Ticket hỗ trợ</h1>
    <p class="text-indigo-200 mt-1">Theo dõi vấn đề liên quan đơn hàng và sản phẩm jeans.</p>
  </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-8">
  <div class="flex items-center justify-between mb-4">
    <div></div>
    <a href="{{ route('support.tickets.create') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Tạo ticket</a>
  </div>

  <div class="rounded-2xl overflow-hidden shadow ring-1 ring-slate-200 bg-white">
    <table class="w-full text-left">
      <thead class="bg-slate-50">
        <tr class="border-b border-slate-200">
          <th class="p-3 text-slate-600 text-sm">Mã</th>
          <th class="p-3 text-slate-600 text-sm">Chủ đề</th>
          <th class="p-3 text-slate-600 text-sm">Trạng thái</th>
          <th class="p-3 text-slate-600 text-sm">Cập nhật</th>
          <th class="p-3 text-slate-600 text-sm"></th>
        </tr>
      </thead>
      <tbody>
        @forelse($tickets as $t)
          <tr class="border-b border-slate-100 hover:bg-indigo-50/40">
            <td class="p-3 font-mono text-xs text-slate-700">{{ $t->code }}</td>
            <td class="p-3 text-slate-800">{{ $t->subject }}</td>
            <td class="p-3">
              @php
                $map = [
                  'open' => 'bg-indigo-600 text-white',
                  'pending' => 'bg-amber-500 text-white',
                  'waiting_customer' => 'bg-slate-600 text-white',
                  'resolved' => 'bg-emerald-600 text-white',
                  'closed' => 'bg-slate-400 text-white'
                ];
                $cls = $map[$t->status] ?? 'bg-slate-600 text-white';
              @endphp
              <span class="text-xs px-2 py-1 rounded {{ $cls }} capitalize">{{ $t->status }}</span>
            </td>
            <td class="p-3 text-sm text-slate-600">{{ $t->updated_at }}</td>
            <td class="p-3">
              <a href="{{ route('support.tickets.show',$t->id) }}" class="text-indigo-600 hover:underline">Xem</a>
            </td>
          </tr>
        @empty
          <tr><td class="p-4 text-slate-500" colspan="5">Chưa có ticket.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $tickets->links() }}
  </div>
</div>
@endsection
