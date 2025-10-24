@extends('layouts.app')

@section('content')
@php
$items = isset($items) ? collect($items) : collect(session('cart', []));
$qtySum = $items->reduce(fn($c,$i)=>$c + ($i['quantity'] ?? ($i['qty'] ?? 1)), 0);
$total = isset($total) ? (int)$total : $items->reduce(fn($s,$i)=>$s + (($i['price'] ?? 0) * ($i['quantity'] ?? ($i['qty'] ?? 1))), 0);
$orderId = session('pending_order_id');

$applied = session('applied_coupon');
$discount = (int)($applied['discount'] ?? 0);
$grandTotal = max(0, (int)$total - $discount);
@endphp

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
  <!-- Header Section -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
          <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
          </div>
          <div>
            <h1 class="text-3xl font-bold text-slate-900">Giỏ hàng của bạn</h1>
            <p class="text-slate-600 mt-1">{{ $qtySum }} sản phẩm đang chờ thanh toán</p>
          </div>
        </div>
        <a href="{{ route('user.products.index') }}"
          class="hidden md:inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
          </svg>
          Tiếp tục mua sắm
        </a>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-8">
    @if($items->isEmpty())
    <!-- Empty Cart State -->
    <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
      <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
      </div>
      <h2 class="text-2xl font-bold text-slate-900 mb-4">Giỏ hàng trống</h2>
      <p class="text-slate-600 mb-8 max-w-md mx-auto">Hãy khám phá bộ sưu tập quần jeans độc đáo của chúng tôi và tìm cho mình những sản phẩm yêu thích!</p>
      <a href="{{ route('user.products.index') }}"
        class="inline-flex items-center gap-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
        Khám phá ngay
      </a>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Cart Items -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
          <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-8 py-6 border-b">
            <h2 class="text-xl font-bold text-slate-900">Sản phẩm trong giỏ</h2>
          </div>
          
          <div class="divide-y divide-slate-100">
            @foreach($items as $key => $it)
            @php
            $id = $it['product_id'] ?? $it['id'] ?? $key;
            $name = $it['name'] ?? ($it['title'] ?? 'Sản phẩm');
            $price= (int) ($it['price'] ?? 0);
            $qty = max(1, (int) ($it['quantity'] ?? ($it['qty'] ?? 1)));
            $sum = $price * $qty;
            $img = $it['image'] ?? ($it['thumbnail'] ?? ($it['images'][0] ?? null));
            $img = $img ?: 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop&crop=center';
            @endphp

            <div class="p-8 hover:bg-slate-50/50 transition-colors duration-200">
              <div class="flex items-start gap-6">
                <!-- Product Image -->
                <div class="relative group">
                  <div class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-100 shadow-md group-hover:shadow-lg transition-shadow duration-200">
                    <img src="{{ $img }}" alt="Ảnh {{ $name }}" class="w-full h-full object-cover">
                  </div>
                  <div class="absolute -top-2 -right-2 w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold">
                    {{ $qty }}
                  </div>
                </div>

                <!-- Product Info -->
                <div class="flex-1 min-w-0">
                  <h3 class="text-lg font-semibold text-slate-900 mb-2 line-clamp-2">{{ $name }}</h3>
                  <div class="flex items-center gap-4 mb-4">
                    <span class="text-2xl font-bold text-indigo-600">{{ number_format($price, 0, ',', '.') }}₫</span>
                    <span class="text-sm text-slate-500">x {{ $qty }}</span>
                  </div>

                  <!-- Quantity Controls -->
                  <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-3 mb-4">
                    @csrf @method('PATCH')
                    <input type="hidden" name="product_id" value="{{ $id }}">
                    <div class="flex items-center bg-slate-100 rounded-xl overflow-hidden">
                      <button type="submit" name="op" value="dec" class="w-10 h-10 flex items-center justify-center hover:bg-slate-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                      </button>
                      <input type="number" name="qty" value="{{ $qty }}" min="1" class="w-16 h-10 text-center bg-transparent border-0 font-semibold">
                      <button type="submit" name="op" value="inc" class="w-10 h-10 flex items-center justify-center hover:bg-slate-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                      </button>
                    </div>
                    <button type="submit" name="op" value="set" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                      Cập nhật
                    </button>
                  </form>

                  <div class="flex items-center justify-between">
                    <span class="text-xl font-bold text-slate-900">{{ number_format($sum, 0, ',', '.') }}₫</span>
                    <form method="POST" action="{{ route('cart.remove') }}">
                      @csrf @method('DELETE')
                      <input type="hidden" name="product_id" value="{{ $id }}">
                      <button type="submit" onclick="return confirm('Xóa sản phẩm này khỏi giỏ?')" 
                        class="flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Xóa
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Order Summary -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden sticky top-8">
          <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-6">
            <h2 class="text-xl font-bold text-white">Tóm tắt đơn hàng</h2>
          </div>
          
          <div class="p-8 space-y-6">
            <!-- Order Details -->
            <div class="space-y-4">
              <div class="flex justify-between items-center py-2">
                <span class="text-slate-600">Số lượng sản phẩm</span>
                <span class="font-semibold text-slate-900">{{ $qtySum }}</span>
              </div>
              <div class="flex justify-between items-center py-2">
                <span class="text-slate-600">Tạm tính</span>
                <span class="font-semibold text-slate-900">{{ number_format($total, 0, ',', '.') }}₫</span>
              </div>

              @if(!empty($applied))
              <div class="flex justify-between items-center py-2 text-green-600">
                <span>Giảm giá ({{ $applied['code'] }})</span>
                <span class="font-semibold">-{{ number_format($discount, 0, ',', '.') }}₫</span>
              </div>
              @endif

              <div class="border-t pt-4">
                <div class="flex justify-between items-center">
                  <span class="text-lg font-semibold text-slate-900">Tổng thanh toán</span>
                  <span class="text-2xl font-bold text-indigo-600">{{ number_format($grandTotal, 0, ',', '.') }}₫</span>
                </div>
              </div>
            </div>

            <!-- Coupon Section -->
            <div class="border-t pt-6">
              <h3 class="font-semibold text-slate-900 mb-4">Mã giảm giá</h3>
              <form action="{{ route('cart.apply_coupon') }}" method="post" class="space-y-3">
                @csrf
                <div class="relative">
                  <input name="code" placeholder="Nhập mã giảm giá" 
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                  <button type="submit" class="absolute right-2 top-2 px-4 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Áp dụng
                  </button>
                </div>
                @if(session('applied_coupon'))
                <button formaction="{{ route('cart.remove_coupon') }}" formmethod="post" 
                  class="w-full px-4 py-2 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">
                  @method('DELETE') @csrf Gỡ mã giảm giá
                </button>
                @endif
              </form>
              @error('code')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
              @if(session('msg'))<p class="text-green-600 text-sm mt-2">{{ session('msg') }}</p>@endif
            </div>

            <!-- Action Buttons -->
            <div class="border-t pt-6 space-y-3">
              @if($orderId)
              <form method="GET" action="{{ url('/payments/checkout') }}">
                <input type="hidden" name="order_id" value="{{ $orderId }}">
                <input type="hidden" name="amount" value="{{ (int) $grandTotal }}">
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                  <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Thanh toán ngay
                  </div>
                </button>
              </form>
              @else
              <form method="POST" action="{{ route('orders.createFromCart') }}">
                @csrf
                <input type="hidden" name="total" value="{{ (int) $grandTotal }}">
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                  <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Thanh toán ngay
                  </div>
                </button>
              </form>
              @endif

              <a href="{{ route('user.products.index') }}"
                class="w-full block text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 rounded-xl transition-colors">
                Tiếp tục mua sắm
              </a>

              <form method="POST" action="{{ route('cart.clear') }}">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Xóa toàn bộ giỏ hàng?')"
                  class="w-full text-red-600 hover:bg-red-50 font-medium py-3 rounded-xl border border-red-200 transition-colors">
                  Xóa toàn bộ giỏ hàng
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Suggested Products -->
    @if(isset($suggested) && $suggested->isNotEmpty())
    <section class="mt-16">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Có thể bạn sẽ thích</h2>
        <p class="text-slate-600 max-w-2xl mx-auto">Khám phá thêm những sản phẩm tuyệt vời khác trong bộ sưu tập của chúng tôi</p>
      </div>
      
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($suggested as $p)
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
          <div class="aspect-square bg-slate-100 overflow-hidden relative">
            @php
            $src = !empty($p->image_url)
            ? (preg_match('/^https?:\/\//',$p->image_url) ? $p->image_url : asset($p->image_url))
            : 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop&crop=center';
            @endphp
            <img src="{{ $src }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
          </div>
          
          <div class="p-4 space-y-3">
            <h3 class="font-semibold text-slate-900 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $p->name }}</h3>
            <div class="text-lg font-bold text-indigo-600">{{ number_format((int)$p->price,0,',','.') }}₫</div>

            <form action="{{ route('cart.add', $p) }}" method="POST" class="space-y-3">
              @csrf
              <div class="flex items-center bg-slate-100 rounded-lg overflow-hidden">
                <button type="button" class="px-3 py-2 hover:bg-slate-200 transition-colors" data-qty-dec>
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                  </svg>
                </button>
                <input type="number" name="quantity" value="1" min="1" max="{{ (int)($p->stock ?? 9999) }}"
                  class="flex-1 text-center border-0 bg-transparent py-2 font-semibold">
                <button type="button" class="px-3 py-2 hover:bg-slate-200 transition-colors" data-qty-inc>
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                  </svg>
                </button>
              </div>
              <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-semibold py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                Thêm vào giỏ
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
</div>

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