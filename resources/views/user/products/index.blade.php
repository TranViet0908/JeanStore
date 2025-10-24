@extends('home')

@section('title', 'Sản phẩm gợi ý')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-900 to-indigo-800 text-white py-20">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Bộ Sưu Tập Jeans <span class="text-yellow-400">Cao Cấp</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-gray-200">
                Khám phá những mẫu quần jeans thời trang, chất lượng cao với giá tốt nhất
            </p>
        </div>
    </div>
</section>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold">Sản phẩm gợi ý</h1>

        <form method="get" class="flex gap-2 items-center">
            <input type="text" name="q" value="{{ $q }}" placeholder="Tìm kiếm..."
                class="border rounded px-3 py-2 w-56">

            <select name="category_id" class="border rounded px-3 py-2 w-56">
                <option value="">Tất cả danh mục</option>
                @foreach($categories ?? [] as $c)
                <option value="{{ $c->id }}" @selected((int)$categoryId===(int)$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>

            <button class="bg-black text-white px-4 py-2 rounded">Lọc</button>
        </form>
    </div>

    @if($products->count() === 0)
    <div class="text-gray-600">Không tìm thấy sản phẩm phù hợp.</div>
    @else
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @php
        // Tham số điều chỉnh
        $randTopCount = 4; // số sản phẩm top theo views_count sẽ random
        $lastChunk = 2; // lấy theo cụm từ nhóm last_view
        $countChunk = 2; // lấy theo cụm từ nhóm views_count
        $injectMin = 1; // chèn tối thiểu n sản phẩm random
        $injectMax = 2; // chèn tối đa n sản phẩm random

        $col = $products->getCollection();

        // helper lấy views_count
        $getViews = function ($x) {
        return (int)($x->pv_views_count ?? $x->views_count ?? $x->views_sum ?? 0);
        };

        // 1) Nhóm A: có last_viewed_at, sort desc theo thời điểm xem
        $last = $col->filter(fn($x) => !empty($x->pv_last_viewed_at))
        ->sortByDesc(fn($x) => strtotime($x->pv_last_viewed_at))
        ->values();

        // 2) Nhóm B: còn lại nhưng có views_count > 0, sort desc theo views_count
        $remaining = $col->reject(fn($x) => !empty($x->pv_last_viewed_at))->values();
        $byCount = $remaining->filter(fn($x) => $getViews($x) > 0)
        ->sortByDesc(fn($x) => $getViews($x))
        ->values();

        // Random "vài cái đầu" của nhóm B
        $byCountTop = $byCount->slice(0, $randTopCount)->shuffle()->values();
        $byCountRest = $byCount->slice($randTopCount)->values();
        $byCount = $byCountTop->concat($byCountRest)->values();

        // 3) Nhóm C: còn lại, random toàn bộ
        $others = $remaining->reject(fn($x) => $getViews($x) > 0)->shuffle()->values();

        // 4) Trộn kết quả: A(lọt 2) + chèn 1–2 C + B(lọt 2) + có thể chèn 1 C, lặp lại
        $final = collect();
        $iA = 0; $iB = 0;

        while ($iA < $last->count() || $iB < $byCount->count()) {
                if ($iA < $last->count()) {
                    $chunk = $last->slice($iA, $lastChunk);
                    $final = $final->concat($chunk);
                    $iA += $chunk->count();
                    }

                    // chèn 1–2 sản phẩm random từ C
                    $inject = rand($injectMin, $injectMax);
                    for ($k = 0; $k < $inject && $others->isNotEmpty(); $k++) {
                        $final->push($others->shift());
                        }

                        if ($iB < $byCount->count()) {
                            $chunk = $byCount->slice($iB, $countChunk);
                            $final = $final->concat($chunk);
                            $iB += $chunk->count();
                            }

                            // 50% cơ hội chèn thêm 1 sản phẩm C
                            if ($others->isNotEmpty() && rand(0,1) === 1) {
                            $final->push($others->shift());
                            }
                            }

                            // nếu còn C thì thêm vào cuối
                            if ($others->isNotEmpty()) {
                            $final = $final->concat($others);
                            }

                            $sorted = $final->values();
                            @endphp

                            @foreach($sorted as $p)

                            <div class="border rounded-xl overflow-hidden flex flex-col relative">
                                {{-- Badges --}}
                                <div class="absolute top-2 left-2 flex gap-2">
                                    @if(($p->total_sold ?? 0) > 0)
                                    <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-800">Bán chạy</span>
                                    @endif
                                    @if(($p->views_sum ?? 0) > 0)
                                    <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-800">Bạn đã xem</span>
                                    @endif
                                    @if(($p->stock ?? 0) <= ($threshold ?? 5))
                                        <span class="text-xs px-2 py-1 rounded bg-red-100 text-red-700">Sắp hết</span>
                                        @endif
                                </div>

                                {{-- Ảnh vuông --}}
                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                    @php
                                    $src = '';
                                    if (!empty($p->image_url)) {
                                    $src = preg_match('/^https?:\/\//', $p->image_url) ? $p->image_url : asset($p->image_url);
                                    }
                                    @endphp
                                    @if($src)
                                    <img src="{{ $src }}" alt="{{ $p->name }}" class="w-full h-full object-cover object-center" loading="lazy" decoding="async">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">No Image</span>
                                    </div>
                                    @endif
                                </div>

                                <div class="p-4 flex flex-col gap-2 flex-1">
                                    <a href="{{ route('user.products.show', $p) }}" class="font-semibold hover:underline">
                                        {{ $p->name }}
                                    </a>
                                    <div class="text-sm text-gray-600">
                                        Giá: {{ number_format((int)($p->price ?? 0), 0, ',', '.') }}₫
                                    </div>
                                    <div class="text-sm text-gray-600">SL còn: {{ (int)($p->stock ?? 0) }}</div>
                                    <div class="text-sm text-gray-600">Đã bán: {{ (int)($p->total_sold ?? 0) }}</div>

                                    <div class="mt-auto space-y-2">
                                        <a href="{{ route('user.products.show', $p) }}"
                                            class="w-full inline-flex items-center justify-center border rounded-xl px-3 py-2 hover:bg-gray-50">
                                            Xem chi tiết
                                        </a>

                                        @auth
                                        <form action="{{ route('cart.add', $p) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <div class="flex items-center border rounded-xl overflow-hidden">
                                                <button type="button" class="px-3 py-2" data-qty-dec>-</button>
                                                <input type="number" name="quantity" value="1" min="1"
                                                    max="{{ (int)($p->stock ?? 0) }}"
                                                    class="w-14 text-center border-0 focus:ring-0 py-2">
                                                <button type="button" class="px-3 py-2" data-qty-inc>+</button>
                                            </div>
                                            <button type="submit"
                                                class="flex-1 inline-flex items-center justify-center bg-black text-white rounded-xl px-3 py-2 hover:bg-gray-900">
                                                Thêm vào giỏ
                                            </button>
                                        </form>
                                        @else
                                        <a href="{{ route('login') }}"
                                            class="w-full inline-flex items-center justify-center bg-black text-white rounded-xl px-3 py-2 hover:bg-gray-900">
                                            Thêm vào giỏ
                                        </a>
                                        @endauth
                                    </div>

                                </div>
                            </div>
                            @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
    @endif
</div>
<script>
    document.addEventListener('click', function(e) {
        const b = e.target.closest('[data-qty-inc],[data-qty-dec]');
        if (!b) return;
        const form = b.closest('form');
        if (!form) return;
        const input = form.querySelector('input[name="quantity"]');
        if (!input) return;
        const max = parseInt(input.max || '999999', 10);
        let v = parseInt(input.value || '1', 10);
        v = b.hasAttribute('data-qty-inc') ? Math.min(v + 1, max) : Math.max(v - 1, 1);
        input.value = v;
    });
</script>
@endsection