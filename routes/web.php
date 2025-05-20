<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleManagementController;

Route::get('/', function () {
    return view('home');
});

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


// Secret Admin

Route::get('/admin-login-secret-1903', [AuthAdminController::class, 'showLoginAdmin'])->name('login.admin');

// Ini penting untuk proses login!
Route::post('/admin-login-secret-1903', [AuthAdminController::class, 'loginAdmin'])->name('login.admin.post');

Route::middleware(['auth:admin', 'is_admin'])->group(function () {
    Route::get('/admin-login-secret-1903/dashboard', function (Request $request) {
        $admin = Auth::guard('admin')->user();
        return view('admin.dashboard', compact('admin'));
    })->name('admin.dashboard');
});


// Admin Dashboard
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});


Route::prefix('role/manage-admin')->middleware('auth:admin')->group(function () {
    Route::get('/', [RoleManagementController::class, 'index'])->name('role.manageadmin.index');
    Route::post('/', [RoleManagementController::class, 'store'])->name('role.manageadmin.store');
    Route::put('/{admin}', [RoleManagementController::class, 'update'])->name('role.manageadmin.update');
    Route::delete('/{admin}', [RoleManagementController::class, 'destroy'])->name('role.manageadmin.destroy');
});

