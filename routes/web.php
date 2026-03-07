<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ── Home ────────────────────────────────────────────────────────────────────

Route::get('/', function () {
    $featuredProducts = \App\Models\Product::with(['productImages', 'category', 'supplier'])->take(6)->get();
    return view('welcome', compact('featuredProducts'));
})->name('home');

// ── Auth ─────────────────────────────────────────────────────────────────────

Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Email verification routes only (no login/register — we use custom ones above)
Auth::routes(['verify' => true, 'register' => false, 'login' => false, 'reset' => true]);

// ── Products (public) ────────────────────────────────────────────────────────

Route::get('/products',      [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ── Cart (guests allowed) ────────────────────────────────────────────────────

Route::post('/products/{id}/add-to-cart', [ProductController::class, 'addToCart'])->name('products.addToCart');
Route::get('/cart',                        [ProductController::class, 'cart'])->name('cart.index');
Route::patch('/cart/{productId}',          [ProductController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/{productId}',         [ProductController::class, 'removeFromCart'])->name('cart.remove');

// ── Authenticated user routes ────────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {

    // Orders & Checkout
    Route::get('/checkout',      [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders',       [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders',        [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}',   [OrderController::class, 'show'])->name('orders.show');

    // Account management
    Route::get('/account',            [UserAccountController::class, 'show'])->name('user.account');
    Route::put('/account',            [UserAccountController::class, 'update'])->name('user.account.update');
    Route::put('/account/password',   [UserAccountController::class, 'updatePassword'])->name('user.account.password');

    // Product reviews
    Route::post('/products/{id}/review', [ProductReviewController::class, 'storeOrUpdate'])->name('products.review');
});

// ── Admin routes ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ── Products ──
    // NOTE: Static segments (/create, /trashed, /import) must come BEFORE
    // the {id} wildcard routes to avoid Laravel resolving them as IDs.
    Route::get('/products/create',         [AdminController::class,  'createProduct'])->name('products.create');
    Route::get('/products/trashed',        [ProductController::class, 'trashed'])->name('products.trashed');
    Route::get('/products/import',         [ProductController::class, 'importForm'])->name('products.importForm');
    Route::post('/products/import',        [ProductController::class, 'import'])->name('products.import');

    Route::get('/products',                [AdminController::class,  'products'])->name('products.index');
    Route::post('/products',               [AdminController::class,  'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit',      [AdminController::class,  'editProduct'])->name('products.edit');
    Route::patch('/products/{id}',         [AdminController::class,  'updateProduct'])->name('products.update');
    Route::delete('/products/{id}',        [AdminController::class,  'destroyProduct'])->name('products.destroy');
    Route::post('/products/{id}/restore',  [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('/products/images/{imageId}', [AdminController::class, 'destroyProductImage'])
    ->name('admin.products.images.destroy');

    // Product reviews (admin)
    Route::get('/products/{id}/reviews', [AdminController::class, 'productReviews'])->name('products.reviews');
    Route::get('/products/{id}/reviews/data', [AdminController::class, 'productReviewsData'])->name('products.reviews.data');
    Route::delete('/reviews/{reviewId}', [AdminController::class, 'destroyProductReview'])->name('products.reviews.destroy');

    // ── Suppliers ──
    Route::get('/suppliers/create',        [AdminController::class, 'createSupplier'])->name('suppliers.create');
    Route::get('/suppliers',               [AdminController::class, 'suppliers'])->name('suppliers.index');
    Route::post('/suppliers',              [AdminController::class, 'storeSupplier'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit',     [AdminController::class, 'editSupplier'])->name('suppliers.edit');
    Route::patch('/suppliers/{id}',        [AdminController::class, 'updateSupplier'])->name('suppliers.update');
    Route::delete('/suppliers/{id}',       [AdminController::class, 'destroySupplier'])->name('suppliers.destroy');

    // ── Users ──
    // NOTE: /users/data must come BEFORE /users/{id} for the same reason.
    Route::get('/users',          [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/data',     [AdminController::class, 'usersData'])->name('users.data');
    Route::patch('/users/{id}',   [AdminController::class, 'updateUser'])->name('users.update');

    // ── Orders ──
    Route::get('/orders',                    [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}',               [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{id}/status',      [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');

    // ── Reviews ──
    Route::get('/reviews',                   [ProductReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}',       [ProductReviewController::class, 'destroy'])->name('reviews.destroy');

    // ── Charts / Reports ──
    Route::get('/charts/best-selling',       [AdminController::class, 'bestSellingChart'])->name('charts.bestSelling');
});