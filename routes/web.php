<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ReservationController;

// =============================================
// HOME & STATIC PAGES
// =============================================
Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// =============================================
// RESERVATION
// =============================================
//Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
//Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.submit');

// =============================================
// MENU
// =============================================
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/filter', [MenuController::class, 'filter'])->name('menu.filter');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');

// =============================================
// CUSTOMER AUTH
// =============================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.submit');

// =============================================
// KERANJANG (CART)
// =============================================
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::post('/cart/direct-add', [CartController::class, 'directAdd'])->name('cart.direct.add');

// =============================================
// CUSTOMER PROTECTED ROUTES
// =============================================
Route::middleware('auth:customer')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/checkout', [CartController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/customer/order/{id}', [DashboardController::class, 'orderDetail'])->name('customer.order.detail');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('customer.orders');
});

// =============================================
// ADMIN AUTH
// =============================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Login/Logout (Tanpa middleware)
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Admin Protected Routes (Harus Login Admin)
    Route::middleware('auth:admin')->group(function () {
        // Dashboard & Orders
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders');
        Route::get('/order/{id}', [AdminDashboardController::class, 'orderDetail'])->name('order.detail');
        Route::put('/order/{id}/status', [AdminDashboardController::class, 'updateStatus'])->name('order.status');
        Route::put('/payment/{id}/verify', [AdminDashboardController::class, 'verifyPayment'])->name('payment.verify');

        // Manajemen Menu (CRUD)
        Route::get('/menu', [AdminDashboardController::class, 'manageMenu'])->name('menu.manage');
        Route::get('/menu/create', [AdminDashboardController::class, 'createMenu'])->name('menu.create');
        Route::post('/menu', [AdminDashboardController::class, 'storeMenu'])->name('menu.store');
        Route::get('/menu/{id}/edit', [AdminDashboardController::class, 'editMenu'])->name('menu.edit');
        Route::put('/menu/{id}', [AdminDashboardController::class, 'updateMenu'])->name('menu.update');
        Route::delete('/menu/{id}', [AdminDashboardController::class, 'destroyMenu'])->name('menu.destroy');

        // Manajemen Customer
        Route::get('/customers', [AdminDashboardController::class, 'customers'])->name('customers');

        // Manajemen Pembayaran & Laporan
        Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments');
        Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    });
});
