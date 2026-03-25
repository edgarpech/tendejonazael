<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [HomeController::class, 'products'])->name('products');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendNewPassword'])->name('password.send');
});

Route::post('/logout', LogoutController::class)->middleware('auth')->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', ProductController::class)->except(['create', 'edit', 'show']);
        Route::delete('products/{product}/image', [ProductController::class, 'destroyImage'])->name('products.image.destroy');
        Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
        Route::resource('brands', BrandController::class)->except(['create', 'edit', 'show']);
        Route::delete('brands/{brand}/logo', [BrandController::class, 'destroyLogo'])->name('brands.logo.destroy');

        Route::middleware('role:admin')->group(function () {
            Route::resource('users', UserController::class)->except(['create', 'edit', 'show']);
            Route::resource('roles', RoleController::class)->except(['create', 'edit', 'show']);
        });
    });
});