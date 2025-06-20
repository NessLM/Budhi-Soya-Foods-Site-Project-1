<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleManagementAdminController;
use App\Http\Controllers\ProductController;

// =====================================
// Public (user)
// =====================================
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/contact', fn () => view('contact'));
Route::get('/aboutus', fn () => view('aboutus'));

// =====================================
// Auth User
// =====================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.user');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




// Daftar

// Tampilkan form register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.user');


// Secret Admin

Route::get('/admin-login-secret-1903', [AuthAdminController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/admin-login-secret-1903', [AuthAdminController::class, 'loginAdmin'])->name('login.admin.post');

// =====================================
// Protected Admin Routes
// =====================================
Route::middleware(['auth:admin', 'is_admin', 'prevent-back-history'])->group(function () {

// Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');


    // Role management
    Route::get('/admin/role-management', [RoleManagementAdminController::class, 'index'])->name('rolemanagementadmin.index');
    Route::post('/admin/role-management', [RoleManagementAdminController::class, 'store'])->name('rolemanagementadmin.store');
    Route::put('/admin/role-management/{id}', [RoleManagementAdminController::class, 'update'])->name('rolemanagementadmin.update');
    Route::delete('/admin/role-management/{id}', [RoleManagementAdminController::class, 'destroy'])->name('rolemanagementadmin.destroy');

    // Produk
    Route::get('/admin/tambahproduk', [ProductController::class, 'add_index'])->name('addproduct.index');
    Route::post('/admin/tambahproduk', [ProductController::class, 'store'])->name('addproduct.store');
    Route::get('/admin/daftarproduk', [ProductController::class, 'list_index'])->name('listproduct.index');
    Route::get('/admin/produk/{id_produk}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/admin/produk/{id_produk}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/admin/produk/{id_produk}', [ProductController::class, 'destroy'])->name('product.destroy');
});

// API Routes for AJAX calls
Route::get('/api/product/{id_produk}', [ProductController::class, 'show'])->name('product.api.show');


