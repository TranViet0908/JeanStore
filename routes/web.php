<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\DB;

// Controllers (site)
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Support\FaqController;
use App\Http\Controllers\Support\LiveChatController;
use App\Http\Controllers\Support\TicketController;
use App\Http\Controllers\User\OrderController as UserOrderController;

// Controllers (admin)
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SupportFaqController as AdminSupportFaqController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
use App\Http\Controllers\Admin\LiveChatController      as AdminLiveChatController;

// Models used in closures
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;

/*
|--------------------------------------------------------------------------
| Guest routes (auth views)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated utility routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/debug-auth', function () {
        $user = Auth::user();
        if ($user) {
            return response()->json([
                'authenticated' => true,
                'user'          => $user,
                'is_admin'      => method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin'),
                'role'          => $user->role,
            ]);
        }
        return response()->json(['authenticated' => false]);
    });
});

/*
|--------------------------------------------------------------------------
| Public site routes
|--------------------------------------------------------------------------
*/
// Trang chủ
Route::get('/', function () {
    $categories = Category::all();
    $featuredProducts = Product::where('stock', '>', 0)->latest()->limit(8)->get();
    return view('home', compact('categories', 'featuredProducts'));
})->middleware(['auth', 'verified'])->name('home');
Route::get('/__where', fn() => base_path());

// /home -> /
Route::redirect('/home', '/'); // optional

// Catalog
Route::get('/products', function () {
    $products = Product::with('category')->paginate(12);
    $categories = Category::all();
    return view('products.index', compact('products', 'categories'));
})->name('products.index');

Route::get('/products/{product}', function (Product $product) {
    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)->limit(4)->get();
    return view('products.show', compact('product', 'relatedProducts'));
})->name('products.show');

// ===== FAQ
Route::get('/support/faq', [FaqController::class, 'index'])->name('support.faq');

// ===== Live Chat (khách hoặc đã đăng nhập)
Route::get('/support/live-chat', [LiveChatController::class, 'index'])->name('support.live_chat');
Route::post('/support/live-chat/send', [LiveChatController::class, 'send'])->name('support.live_chat.send');
Route::get('/support/live-chat/poll', [LiveChatController::class, 'poll'])->name('support.live_chat.poll');

// ===== Ticket (user). Khách vẫn tạo được nếu bạn muốn: mở comment ở dưới.
Route::middleware('auth')->group(function () {
    Route::get('/support/tickets', [TicketController::class, 'index'])->name('support.tickets.index');
    Route::get('/support/tickets/create', [TicketController::class, 'create'])->name('support.tickets.create');
    Route::post('/support/tickets', [TicketController::class, 'store'])->name('support.tickets.store');
    Route::get('/support/tickets/{id}', [TicketController::class, 'show'])->name('support.tickets.show');
    Route::post('/support/tickets/{id}/reply', [TicketController::class, 'reply'])->name('support.tickets.reply');
});

/*
|--------------------------------------------------------------------------
| Email verification
|--------------------------------------------------------------------------
*/
// Trang nhắc xác minh
Route::get('/email/verify', fn() => view('auth.verify-email'))
    ->middleware('auth')
    ->name('verification.notice');

// Link trong email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $r) {
    // nếu đã verify thì bỏ qua
    if ($r->user()->hasVerifiedEmail()) {
        return redirect()->route('home');
    }
    $r->fulfill();                         // set email_verified_at
    return redirect()->route('home');      // về trang chủ
})->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');

// Gửi lại email
Route::post('/email/verification-notification', function (Request $r) {
    if (! $r->user()->hasVerifiedEmail()) {
        $r->user()->sendEmailVerificationNotification();
    }
    return back()->with('message', 'Đã gửi lại liên kết xác minh.');
})->middleware(['auth', 'throttle:3,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Cart + Checkout (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply_coupon');
        Route::delete('/remove-coupon', [CartController::class, 'removeCoupon'])->name('remove_coupon');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::patch('/update', [CartController::class, 'update'])->name('update');
        Route::delete('/remove', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });

    // Checkout page
    Route::get('/checkout', function () {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $items = $cart->items()->with('product')->get();
        $subtotal = $items->sum(fn($i) => (int) (($i->price ?? $i->product->price ?? 0) * $i->quantity));
        $shipping = 0;
        $grand = $subtotal + $shipping;
        return view('order.checkout', compact('items', 'subtotal', 'shipping', 'grand'));
    })->name('order.checkout');

    // Place order
    Route::post('/checkout', [OrderController::class, 'store'])->name('order.place');

    // Success page
    Route::get('/order/success/{order}', function (Order $order) {
        return view('order.success', compact('order'));
    })->name('order.success');

    // Order history
    Route::get('/account/orders', function () {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('order.history', compact('orders'));
    })->name('order.history');

    // Order detail
    Route::get('/account/orders/{order}', function (Order $order) {
        $user = auth()->user();
        abort_unless(($user->role ?? null) === 'admin' || $order->user_id === $user->id, 403);

        // Ưu tiên quan hệ nếu có
        $items = collect();
        if (method_exists($order, 'items')) {
            try {
                $items = $order->items()->with('product')->get();
            } catch (\Throwable $e) {
            }
        }

        // Fallback: join products, KHÔNG dùng cột không tồn tại
        if ($items->isEmpty()) {
            $items = DB::table('order_items as oi')
                ->where('oi.order_id', $order->id)
                ->leftJoin('products as p', 'oi.product_id', '=', 'p.id')
                ->select(
                    'oi.id',
                    'oi.product_id',
                    'oi.quantity',
                    DB::raw('oi.price as price'),
                    DB::raw('p.name as name'),
                    DB::raw('p.image_url as image')
                )
                ->get();
        }

        $shipping = 0;
        $subtotal = $items->sum(function ($i) {
            $price = is_numeric($i->price) ? (float)$i->price : 0;
            $qty   = (int)($i->quantity ?? 1);
            return (int)round($price) * $qty;
        });

        return view('order.detail', compact('order', 'items', 'shipping', 'subtotal'));
    })->name('order.detail');
});

/*
|--------------------------------------------------------------------------
| Public order tracking
|--------------------------------------------------------------------------
*/
Route::get('/track-order', function () {
    return view('order.track');
})->name('order.track');

Route::post('/track-order', function (Request $request) {
    $data = $request->validate(['order_id' => 'required|integer']);
    $order = Order::find($data['order_id']);
    if ($order) {
        return view('order.track', ['found' => true, 'order' => $order]);
    }
    return view('order.track', ['found' => false]);
})->name('order.track.submit');

Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');

/*
|--------------------------------------------------------------------------
| Site orders + payments
|--------------------------------------------------------------------------
*/
// Site orders + payments
Route::get('/orders/{id}', [OrderController::class, 'detail'])->name('orders.detail');
Route::post('/orders/create-from-cart', [OrderController::class, 'createFromCart'])->name('orders.createFromCart');

Route::prefix('payments')->name('payments.')->group(function () {
    Route::post('/', [PaymentController::class, 'create'])->name('create');
    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');

    // VNPAY callback -> đúng method
    Route::get('/vnpay/return', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');

    // giữ alias cũ (nếu nơi nào còn dùng /payments/return)
    Route::get('/return', [PaymentController::class, 'vnpayReturn'])->name('return');

    Route::match(['GET', 'POST'], '/webhook', [PaymentController::class, 'webhook'])->name('webhook');
});

// Nhóm "user/products"
Route::prefix('user/products')->name('user.products.')->group(function () {
    Route::get('/', [UserProductController::class, 'index'])->name('index');
    Route::get('/{product}', [UserProductController::class, 'show'])->name('show');
});

Route::middleware(['auth'])->prefix('user/orders')->name('user.orders.')->group(function () {
    Route::get('/', [UserOrderController::class, 'index'])->name('index');
    Route::get('/{order}', [UserOrderController::class, 'show'])
        ->whereNumber('order')
        ->name('show');
    Route::patch('/{order}/cancel', [UserOrderController::class, 'cancel'])
        ->whereNumber('order')
        ->name('cancel');
});
/*
|--------------------------------------------------------------------------
| Admin routes (middleware 'admin')
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users', AdminUserController::class);
    Route::patch('users/{user}/change-role', [AdminUserController::class, 'changeRole'])
        ->name('users.change_role');

    // Orders
    Route::resource('orders', AdminOrderController::class)
        ->only(['index', 'show', 'edit', 'update', 'destroy']);

    // Categories
    Route::resource('categories', AdminCategoryController::class);

    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');

    // đặt TRƯỚC các route có {product} để không nuốt "create"
    Route::get('/products/create', function () {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    })->name('products.create');

    Route::get('/products/{product}/edit', function ($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    })->whereNumber('product')->name('products.edit');

    Route::post('/products', function (Request $request) {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image_url'] = '/images/products/' . $imageName;
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo thành công!');
    })->name('products.store');

    Route::put('/products/{product}', function (Request $request, $id) {
        $product = Product::findOrFail($id);
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($product->image_url && file_exists(public_path($product->image_url))) {
                @unlink(public_path($product->image_url));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image_url'] = '/images/products/' . $imageName;
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    })->whereNumber('product')->name('products.update');

    Route::get('/products/{product}', [AdminProductController::class, 'show'])
        ->whereNumber('product')->name('products.show');

    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])
        ->whereNumber('product')->name('products.destroy');

    // Payments & Coupons (đang dùng)
    Route::resource('payments', AdminPaymentController::class);
    Route::resource('coupons',  AdminCouponController::class);

    Route::resource('reviews',   AdminReviewController::class);
    Route::resource('faqs',      AdminSupportFaqController::class);
    Route::resource('tickets',   AdminSupportTicketController::class);
    Route::resource('livechats', AdminLiveChatController::class);

    // API helpers
    Route::get('/api/products/search', [AdminProductController::class, 'search'])->name('products.search');
    Route::get('/api/products/category/{category}', [AdminProductController::class, 'byCategory'])
        ->name('products.by-category');
});
