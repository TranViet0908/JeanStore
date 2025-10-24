@extends('layouts.app')

@section('content')
@php
$items = isset($items) ? collect($items) : collect(session('cart', []));
$qtySum = $items->reduce(fn($c,$i)=>$c + ($i['quantity'] ?? ($i['qty'] ?? 1)), 0);
$total  = isset($total) ? (int)$total : $items->reduce(fn($s,$i)=>$s + (($i['price'] ?? 0) * ($i['quantity'] ?? ($i['qty'] ?? 1))), 0);
$orderId = session('pending_order_id');

$applied  = session('applied_coupon');
$discount = isset($discount) ? (int)$discount : (int)($applied['discount'] ?? 0);
$grandTotal = isset($grandTotal) ? (int)$grandTotal : max(0, (int)$total - $discount);
@endphp

<div class="max-w-6xl mx-auto px-4 py-8">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Giỏ hàng</h1>
    <a href="{{ route('user.products.index') }}"
      class="hidden md:inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-black font-semibold px-4 py-2 rounded-lg">
      Tiếp tục mua sắm
    </a>
  </div>

  @if($items->isEmpty())
  <div class="bg-white shadow rounded p-10 text-center">
    <p class="mb-6 text-gray-600">Giỏ hàng trống.</p>
    <a href="{{ route('user.products.index') }}"
      class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-black font-semibold px-6 py-3 rounded-lg">
      Mua ngay
    </a>
  </div>
  @else
  <div class="grid grid-cols-1 gap-6">
  {{-- Danh sách sản phẩm + tổng quan dưới bảng --}}
  <div class="bg-white shadow rounded-2xl overflow-hidden ring-1 ring-slate-200">
    <table class="min-w-full table-auto">
      <thead>
        <tr class="bg-slate-50 text-xs uppercase text-slate-600">
          <th class="px-6 py-3 text-left">Sản phẩm</th>
          <th class="px-6 py-3 text-right">Đơn giá</th>
          <th class="px-6 py-3 text-center">Số lượng</th>
          <th class="px-6 py-3 text-right">Thành tiền</th>
          <th class="px-6 py-3 text-center">Xóa</th>
        </tr>
      </thead>

      <tbody class="divide-y">
        @foreach($items as $key => $it)
          @php
            $id   = $it['product_id'] ?? $it['id'] ?? $key;
            $name = $it['name'] ?? ($it['title'] ?? 'Sản phẩm');
            $price= (int) ($it['price'] ?? 0);
            $qty  = max(1, (int) ($it['quantity'] ?? ($it['qty'] ?? 1)));
            $sum  = $price * $qty;
            $img  = $it['image'] ?? ($it['thumbnail'] ?? ($it['images'][0] ?? null));
            $img  = $img ?: 'https://placehold.co/96x96?text=No+Image';
          @endphp

          <tr class="hover:bg-slate-50/60">
            <td class="px-6 py-4">
              <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-lg overflow-hidden border bg-slate-100 shrink-0">
                  <img src="{{ $img }}" alt="Ảnh {{ $name }}" class="h-full w-full object-cover object-center">
                </div>
                <div class="font-medium text-slate-500 truncate whitespace-nowrap max-w-[22ch]" title="{{ $name }}">
                  {{ \Illuminate\Support\Str::limit($name, 40) }}
                </div>
              </div>
            </td>

            <td class="px-6 py-4 text-right whitespace-nowrap">
              {{ number_format($price, 0, ',', '.') }} đ
            </td>

            <td class="px-6 py-4">
              <form method="POST" action="{{ route('cart.update') }}" class="mx-auto flex items-center justify-center gap-3">
                @csrf @method('PATCH')
                <input type="hidden" name="product_id" value="{{ $id }}">
                <button type="submit" name="op" value="dec" class="h-9 w-9 rounded-lg border bg-white hover:bg-slate-100">−</button>
                <input type="number" name="qty" value="{{ $qty }}" min="1" class="w-16 h-9 text-center border rounded-lg">
                <button type="submit" name="op" value="inc" class="h-9 w-9 rounded-lg border bg-white hover:bg-slate-100">+</button>
                <button type="submit" name="op" value="set" class="h-9 px-4 rounded-lg bg-indigo-900 text-white text-sm whitespace-nowrap hover:bg-indigo-800">
                  Cập nhật
                </button>
              </form>
            </td>

            <td class="px-6 py-4 text-right font-semibold whitespace-nowrap">
              {{ number_format($sum, 0, ',', '.') }} đ
            </td>

            <td class="px-6 py-4 text-center">
              <form method="POST" action="{{ route('cart.remove') }}">
                @csrf @method('DELETE')
                <input type="hidden" name="product_id" value="{{ $id }}">
                <button type="submit" onclick="return confirm('Xóa sản phẩm này khỏi giỏ?')" class="px-3 py-1 rounded-lg border text-red-600 hover:bg-red-50">
                  Xóa
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Tổng quan + mã giảm + nút --}}
    <div class="border-t bg-slate-50 px-4 md:px-6 py-4">
      <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
        <div class="space-y-2 text-sm">
          <div class="flex items-center gap-2 text-slate-600">
            <span>Tổng số sản phẩm</span>
            <span class="font-semibold text-slate-900">{{ $qtySum }}</span>
          </div>
          <div class="flex items-center gap-2 text-slate-600">
            <span>Tạm tính</span>
            <span class="font-semibold text-slate-900">{{ number_format($total, 0, ',', '.') }} đ</span>
          </div>

          @if(!empty($applied))
            <div class="flex items-center gap-2 text-emerald-700">
              <span>Giảm ({{ $applied['code'] }})</span>
              <span class="font-semibold">-{{ number_format($discount, 0, ',', '.') }} đ</span>
            </div>
          @endif

          <div class="flex items-center gap-2 text-slate-900">
            <span class="font-semibold">Tổng thanh toán</span>
            <span class="font-bold text-lg">{{ number_format($grandTotal, 0, ',', '.') }} đ</span>
          </div>

          {{-- form mã giảm giá --}}
          <form action="{{ route('cart.apply_coupon') }}" method="post" class="mt-2 flex gap-2">
            @csrf
            <input name="code" placeholder="Nhập mã cá nhân" class="border rounded px-3 py-2 w-48" />
            <button class="bg-black text-white px-4 py-2 rounded">Áp dụng</button>
            @if(session('applied_coupon'))
              <button formaction="{{ route('cart.remove_coupon') }}" formmethod="post"
                class="px-4 py-2 border rounded">@method('DELETE') @csrf Gỡ mã</button>
            @endif
          </form>
          @error('code')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
          @if(session('msg'))<p class="text-green-700 text-sm mt-1">{{ session('msg') }}</p>@endif
        </div>

        <div class="flex flex-col sm:flex-row gap-3 md:ml-auto">
          @if($orderId)
            <form method="GET" action="{{ url('/payments/checkout') }}">
              <input type="hidden" name="order_id" value="{{ $orderId }}">
              <input type="hidden" name="amount"   value="{{ (int) $grandTotal }}">
              <button type="submit" class="px-4 py-2.5 rounded-lg bg-indigo-900 text-white font-semibold hover:bg-indigo-800 w-full sm:w-auto">
                Thanh toán
              </button>
            </form>
          @else
            <form method="POST" action="{{ route('orders.createFromCart') }}">
              @csrf
              <input type="hidden" name="total" value="{{ (int) $grandTotal }}">
              <button type="submit" class="px-4 py-2.5 rounded-lg bg-indigo-900 text-white font-semibold hover:bg-indigo-800 w-full sm:w-auto">
                Thanh toán
              </button>
            </form>
          @endif

          <a href="{{ route('user.products.index') }}"
             class="px-4 py-2.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-black font-semibold w-full sm:w-auto text-center">
            Tiếp tục mua sắm
          </a>

          <form method="POST" action="{{ route('cart.clear') }}">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Xóa toàn bộ giỏ hàng?')"
              class="px-4 py-2.5 rounded-lg border text-red-700 border-red-300 hover:bg-red-50 w-full sm:w-auto">
              Xóa giỏ
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

  {{-- Gợi ý --}}
  @if(isset($suggested) && $suggested->isNotEmpty())
  <section class="max-w-6xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4 text-slate-900">Có thể bạn sẽ thích</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
      @foreach($suggested as $p)
      <div class="group bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
        <div class="aspect-square bg-slate-100 overflow-hidden">
          @php
          $src = !empty($p->image_url)
          ? (preg_match('/^https?:\/\//',$p->image_url) ? $p->image_url : asset($p->image_url))
          : null;
          @endphp
          @if($src)
          <img src="{{ $src }}" alt="{{ $p->name }}" class="w-full h-full object-cover object-center" loading="lazy">
          @endif
        </div>
        <div class="p-3 space-y-2">
          <div class="text-sm font-medium line-clamp-2 text-slate-900">{{ $p->name }}</div>
          <div class="text-sm text-slate-600">{{ number_format((int)$p->price,0,',','.') }}₫</div>

          <form action="{{ route('cart.add', $p) }}" method="POST" class="flex items-center gap-2">
            @csrf
            <div class="flex items-center border rounded-lg overflow-hidden">
              <button type="button" class="px-2 py-1" data-qty-dec>−</button>
              <input type="number" name="quantity" value="1" min="1"
                max="{{ (int)($p->stock ?? 9999) }}"
                class="w-12 text-center border-0 py-1">
              <button type="button" class="px-2 py-1" data-qty-inc>+</button>
            </div>
            <button type="submit"
              class="flex-1 inline-flex items-center justify-center bg-indigo-900 hover:bg-indigo-800 text-white rounded-lg px-3 py-2 text-sm">
              Thêm
            </button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
  </section>
  @endif
  @endif
</div>

{{-- JS tăng/giảm số lượng cho các form gợi ý --}}
<script>
  document.addEventListener('click', function(e) {
    const btn = e.target.closest('[data-qty-inc],[data-qty-dec]');
    if (!btn) return;
    const wrap = btn.closest('form');
    if (!wrap) return;
    const input = wrap.querySelector('input[name="quantity"]');
    if (!input) return;
    const max = parseInt(input.max || '999999', 10);
    let v = parseInt(input.value || '1', 10);
    v = btn.hasAttribute('data-qty-inc') ? Math.min(v + 1, max) : Math.max(v - 1, 1);
    input.value = v;
  });
</script>
@endsection
