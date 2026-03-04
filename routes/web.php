<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProducts = \App\Models\Product::with(['productImages', 'category', 'supplier'])->take(6)->get();
    return view('welcome', compact('featuredProducts'));
})->name('home');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{id}/add-to-cart', [ProductController::class, 'addToCart'])->name('products.addToCart');

// Cart routes
Route::get('/cart', [ProductController::class, 'cart'])->name('cart.index');
Route::patch('/cart/{productId}', [ProductController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/{productId}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

// Order routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::patch('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');

    // Suppliers
    Route::get('/suppliers', [AdminController::class, 'suppliers'])->name('suppliers.index');
    Route::get('/suppliers/create', [AdminController::class, 'createSupplier'])->name('suppliers.create');
    Route::post('/suppliers', [AdminController::class, 'storeSupplier'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [AdminController::class, 'editSupplier'])->name('suppliers.edit');
    Route::patch('/suppliers/{id}', [AdminController::class, 'updateSupplier'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [AdminController::class, 'destroySupplier'])->name('suppliers.destroy');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');

    // Charts / Reports
    Route::get('/charts/best-selling', [AdminController::class, 'bestSellingChart'])->name('charts.bestSelling');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
