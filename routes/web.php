<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Frontend Routes
Route::get('/', function () {
    $featuredProducts = Product::with('images')->orderBy('price', 'desc')->take(8)->get();
    return Inertia::render('Home', ['featuredProducts' => $featuredProducts]);
})->name('home');

Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Routes
Route::group(['middleware' => 'redirectAdmin', 'prefix' => 'admin'], function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['admin', 'auth'])->prefix('admin')->group(function () {
    // products
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::post('/products/create', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::delete('/admin/product-images/{image}', [ProductController::class, 'destroyImage'])->name('admin.product_images.destroy');

    // brands
    Route::get('/brands', [BrandController::class, 'index'])->name('admin.brands.index');
    Route::post('/brands/create', [BrandController::class, 'store'])->name('admin.brands.store');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('admin.brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('admin.brands.destroy');

    // categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
});
require __DIR__ . '/auth.php';
