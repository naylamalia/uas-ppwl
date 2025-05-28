<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

// Auth Pages
Route::middleware('guest')->group(function () {
    Route::view('/signin', 'account-pages.signin')->name('signin');
    Route::view('/signup', 'account-pages.signup')->name('signup');

    Route::get('/sign-up', [RegisterController::class, 'create'])->name('sign-up');
    Route::post('/sign-up', [RegisterController::class, 'store']);

    Route::get('/sign-in', [LoginController::class, 'create'])->name('sign-in');
    Route::post('/sign-in', [LoginController::class, 'store']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store']);
});

// Logout
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Admin routes - Tanpa pengecekan role di route
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::get('/products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');

    Route::get('/stock', [ProductController::class, 'stock'])->name('stock.index');
    Route::get('/stock/{id}/add', [ProductController::class, 'showAddStockForm'])->name('stock.form');
    Route::post('/stock/add/{id}', [ProductController::class, 'addStock'])->name('stock.add');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/export/pdf', [AdminOrderController::class, 'exportPdf'])->name('orders.export.pdf');

    Route::get('/users-management', [UserController::class, 'index'])->name('users.management');
    Route::get('/users', [UserController::class, 'index'])->name('users-management'); // Alias untuk kompatibilitas
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});

// Customer routes - Tanpa pengecekan role di route
Route::prefix('customer')->middleware('auth')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Produk
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [CustomerProductController::class, 'index'])->name('index');
        Route::get('/{id}', [CustomerProductController::class, 'show'])->name('show');

        // Reviews
        Route::get('/{product}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });

    // Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [CustomerOrderController::class, 'index'])->name('index');
        Route::post('/', [CustomerOrderController::class, 'store'])->name('store');
        Route::get('/{id}', [CustomerOrderController::class, 'show'])->name('show');
    });
});