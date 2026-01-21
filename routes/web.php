<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UserController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [HomeController::class, 'products'])->name('products');
Route::get('/producto/{product:slug}', [HomeController::class, 'show'])->name('product.show');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', LogoutController::class)->middleware('auth')->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('brands', BrandController::class)->except('show');

        Route::middleware('role:admin')->group(function () {
            Route::resource('users', UserController::class);
        });
    });
});