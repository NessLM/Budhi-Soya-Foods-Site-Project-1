<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleManagementAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;

// =====================
// Public Routes
// =====================
Route::get('/', function () {
    $products = Product::where('jumlah_produk', '>', 0)
        ->inRandomOrder()
        ->take(3)
        ->get();
    return view('home', compact('products'));
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/aboutus', function () {
    return view('aboutus');
})->name('aboutus');

// Auth (login/register) tetap public
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.user');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.user');

// Halaman login admin
Route::get('/admin-login-secret-1903', [AuthAdminController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/admin-login-secret-1903', [AuthAdminController::class, 'loginAdmin'])->name('login.admin.post');

// =====================================
// Protected Routes (auth)
// =====================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/product', [ProductController::class, 'index'])->name('product');


    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::delete('/orders/{id}/delete', [OrderController::class, 'delete'])->name('orders.delete');
    Route::post('/orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirmPayment');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/profile/add-address', [ProfileController::class, 'addAddress'])->name('profile.addAddress');
    Route::delete('/profile/delete-address/{id}', [ProfileController::class, 'deleteAddress'])->name('profile.deleteAddress');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});


// =====================================
// Protected Admin Routes
// =====================================
Route::middleware(['auth:admin', 'is_admin', 'prevent-back-history'])->group(function () {
    
    // Admin Logout - harus di dalam middleware admin
    Route::post('/admin/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

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