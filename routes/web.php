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
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ReviewController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [HomeController::class, 'products'])->name('products');
Route::get('/aviso-de-privacidad', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/sobre-nosotros', [HomeController::class, 'about'])->name('about');
Route::get('/preguntas-frecuentes', [HomeController::class, 'faq'])->name('faq');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [HomeController::class, 'blogShow'])->name('blog.show');
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
        // Products
        Route::get('products', [ProductController::class, 'index'])->middleware('permission:products.view')->name('products.index');
        Route::post('products', [ProductController::class, 'store'])->middleware('permission:products.create')->name('products.store');
        Route::match(['put', 'patch'], 'products/{product}', [ProductController::class, 'update'])->middleware('permission:products.edit')->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->middleware('permission:products.delete')->name('products.destroy');
        Route::delete('products/{product}/image', [ProductController::class, 'destroyImage'])->middleware('permission:products.edit')->name('products.image.destroy');
        Route::get('products-quick-photo', [ProductController::class, 'quickPhoto'])->middleware('permission:products.quick-photo')->name('products.quick-photo');
        Route::get('products-find-by-sku', [ProductController::class, 'findBySku'])->middleware('permission:products.quick-photo')->name('products.find-by-sku');
        Route::post('products/{product}/image', [ProductController::class, 'updateImage'])->middleware('permission:products.quick-photo')->name('products.image.update');

        // Categories
        Route::get('categories', [CategoryController::class, 'index'])->middleware('permission:categories.view')->name('categories.index');
        Route::post('categories', [CategoryController::class, 'store'])->middleware('permission:categories.create')->name('categories.store');
        Route::match(['put', 'patch'], 'categories/{category}', [CategoryController::class, 'update'])->middleware('permission:categories.edit')->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->middleware('permission:categories.delete')->name('categories.destroy');

        // Brands
        Route::get('brands', [BrandController::class, 'index'])->middleware('permission:brands.view')->name('brands.index');
        Route::post('brands', [BrandController::class, 'store'])->middleware('permission:brands.create')->name('brands.store');
        Route::match(['put', 'patch'], 'brands/{brand}', [BrandController::class, 'update'])->middleware('permission:brands.edit')->name('brands.update');
        Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->middleware('permission:brands.delete')->name('brands.destroy');
        Route::delete('brands/{brand}/logo', [BrandController::class, 'destroyLogo'])->middleware('permission:brands.edit')->name('brands.logo.destroy');

        // Articles (incluye create/edit como vistas separadas)
        Route::get('articles', [ArticleController::class, 'index'])->middleware('permission:articles.view')->name('articles.index');
        Route::get('articles/create', [ArticleController::class, 'create'])->middleware('permission:articles.create')->name('articles.create');
        Route::post('articles', [ArticleController::class, 'store'])->middleware('permission:articles.create')->name('articles.store');
        Route::get('articles/{article}/edit', [ArticleController::class, 'edit'])->middleware('permission:articles.edit')->name('articles.edit');
        Route::match(['put', 'patch'], 'articles/{article}', [ArticleController::class, 'update'])->middleware('permission:articles.edit')->name('articles.update');
        Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->middleware('permission:articles.delete')->name('articles.destroy');
        Route::delete('articles/{article}/image', [ArticleController::class, 'destroyImage'])->middleware('permission:articles.edit')->name('articles.image.destroy');

        // Reviews
        Route::get('reviews', [ReviewController::class, 'index'])->middleware('permission:reviews.view')->name('reviews.index');
        Route::post('reviews', [ReviewController::class, 'store'])->middleware('permission:reviews.create')->name('reviews.store');
        Route::match(['put', 'patch'], 'reviews/{review}', [ReviewController::class, 'update'])->middleware('permission:reviews.edit')->name('reviews.update');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->middleware('permission:reviews.delete')->name('reviews.destroy');

        Route::middleware('role:admin')->group(function () {
            // Users
            Route::get('users', [UserController::class, 'index'])->middleware('permission:users.view')->name('users.index');
            Route::post('users', [UserController::class, 'store'])->middleware('permission:users.create')->name('users.store');
            Route::match(['put', 'patch'], 'users/{user}', [UserController::class, 'update'])->middleware('permission:users.edit')->name('users.update');
            Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('permission:users.delete')->name('users.destroy');

            // Roles
            Route::get('roles', [RoleController::class, 'index'])->middleware('permission:roles.view')->name('roles.index');
            Route::post('roles', [RoleController::class, 'store'])->middleware('permission:roles.create')->name('roles.store');
            Route::match(['put', 'patch'], 'roles/{role}', [RoleController::class, 'update'])->middleware('permission:roles.edit')->name('roles.update');
            Route::delete('roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:roles.delete')->name('roles.destroy');
        });
    });
});