<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;

// ── Home ────────────────────────────────────────────────────────────────────

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', fn() => redirect('/'));

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Products ──
    Route::get('/products/create',              [AdminProductController::class, 'create'])->name('products.create');
    Route::get('/products/trashed',             [ProductController::class, 'trashed'])->name('products.trashed');       // ← unchanged
    Route::get('/products/import',              [ProductController::class, 'importForm'])->name('products.importForm'); // ← unchanged
    Route::post('/products/import',             [ProductController::class, 'import'])->name('products.import');         // ← unchanged

    Route::get('/products/data',                [AdminProductController::class, 'data'])->name('products.data');

    Route::get('/products',                     [AdminProductController::class, 'index'])->name('products.index');
    Route::post('/products',                    [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit',           [AdminProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{id}',              [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}',             [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{id}/restore',       [ProductController::class, 'restore'])->name('products.restore');       // ← unchanged
    Route::delete('/products/images/{imageId}', [AdminProductController::class, 'destroyImage'])->name('admin.products.images.destroy');

    // Product reviews (admin)
    Route::get('/products/{id}/reviews', [AdminController::class, 'productReviews'])->name('products.reviews');
    Route::get('/products/{id}/reviews/data', [AdminController::class, 'productReviewsData'])->name('products.reviews.data');
    Route::delete('/reviews/{reviewId}', [AdminController::class, 'destroyProductReview'])->name('products.reviews.destroy');

    // ── Suppliers ──
    
    Route::get('/suppliers/create',    [AdminSupplierController::class, 'create'])->name('suppliers.create');
    Route::get('/suppliers/data',      [AdminSupplierController::class, 'data'])->name('suppliers.data');
    Route::get('/suppliers',           [AdminSupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers',          [AdminSupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [AdminSupplierController::class, 'edit'])->name('suppliers.edit');
    Route::patch('/suppliers/{id}',    [AdminSupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}',   [AdminSupplierController::class, 'destroy'])->name('suppliers.destroy');

    // ── Users ──
    // NOTE: /users/data must come BEFORE /users/{id} for the same reason.
    Route::get('/users',          [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/data',     [AdminController::class, 'usersData'])->name('users.data');
    Route::patch('/users/{id}',   [AdminController::class, 'updateUser'])->name('users.update');

    // ── Orders ──
    Route::get('/orders',               [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/data',          [AdminOrderController::class, 'data'])->name('orders.data');
    Route::get('/orders/{id}',          [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // ── Reviews ──
    Route::get('/reviews',                   [ProductReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}',       [ProductReviewController::class, 'destroy'])->name('reviews.destroy');

    // ── Charts / Reports ──
    Route::get('/charts/best-selling',       [AdminController::class, 'bestSellingChart'])->name('charts.bestSelling');
});