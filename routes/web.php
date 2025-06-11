<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleManagementAdminController;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'home'])->name('home');

Route::get('/product', function () {
    return view('product');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/aboutus', function () {
    return view('aboutus');
});

// Login

// Tampilkan form login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.user');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Daftar

// Tampilkan form register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Proses form register
Route::post('/register', [AuthController::class, 'register'])->name('register.user');

// Email Verification Routes
Route::get('/verify-email', [AuthController::class, 'showVerifyEmail'])->name('verify.email.form');
Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::post('/resend-otp', [AuthController::class, 'resendOTP'])->name('resend.otp');

// Secret Admin

Route::get('/admin-login-secret-1903', [AuthAdminController::class, 'showLoginAdmin'])->name('login.admin');

// Ini penting untuk proses login!
Route::post('/admin-login-secret-1903', [AuthAdminController::class, 'loginAdmin'])->name('login.admin.post');

Route::middleware(['auth:admin', 'is_admin', 'prevent-back-history'])->group(function () {
    Route::get('/admin-login-secret-1903/dashboard', function (Request $request) {
        $admin = Auth::guard(name: 'admin')->user();
        return view('admin.dashboard', compact('admin'));
    })->name('admin.dashboard');
});


// Admin Dashboard
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Route Management
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/role-management', [RoleManagementAdminController::class, 'index'])->name('rolemanagementadmin.index');
    Route::post('/admin/role-management', [RoleManagementAdminController::class, 'store'])->name('rolemanagementadmin.store');
    Route::put('/admin/role-management/{id}', [RoleManagementAdminController::class, 'update'])->name('rolemanagementadmin.update');
    Route::delete('/admin/role-management/{id}', [RoleManagementAdminController::class, 'destroy'])->name('rolemanagementadmin.destroy');
});

Route::middleware(['auth:admin'])->group(function(){
    Route::get('/admin/tambahproduk', [ProductController::class, 'add_index'])->name('addproduct.index');
    Route::post('/admin/tambahproduk', [ProductController::class, 'store'])->name('addproduct.store');

    Route::get('/admin/daftarproduk', [ProductController::class, 'list_index'])->name('listproduct.index');

    Route::get('/admin/produk/{id_produk}/edit', [ProductController::class, 'edit'])->name('product.edit');  // <-- route edit GET
    Route::put('/admin/produk/{id_produk}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/admin/produk/{id_produk}', [ProductController::class, 'destroy'])->name('product.destroy');
});