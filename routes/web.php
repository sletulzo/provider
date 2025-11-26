<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderWaitingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\Auth\SendUserPasswordResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    // Dashboard 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/section/order-waiting', [DashboardController::class, 'sectionOrderWaiting'])->name('section.order-waiting');
    Route::post('/section/order-email', [DashboardController::class, 'sectionOrderEmail'])->name('section.order-email');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Providers
    Route::get('/providers', [ProviderController::class, 'index'])->name('providers');
    Route::get('/providers/create', [ProviderController::class, 'create'])->name('providers.create');
    Route::get('/providers/{provider}/edit', [ProviderController::class, 'edit'])->name('providers.edit');
    Route::post('/providers/save', [ProviderController::class, 'store'])->name('providers.store');
    Route::post('/providers/{provider}/update', [ProviderController::class, 'update'])->name('providers.update');
    Route::get('/providers/{provider}/delete', [ProviderController::class, 'destroy'])->name('providers.delete');
    Route::post('/providers/products', [ProviderController::class, 'products'])->name('providers.products');
    Route::post('/providers/products/{product}/quantity', [ProviderController::class, 'updateProductQuantity'])->name('providers.products.quantity');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/save', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.delete');

    // Order waiting
    Route::post('/order-waiting/save', [OrderWaitingController::class, 'save'])->name('order-waiting.save');
    Route::post('/order-waiting/quantity/{orderWaiting}/update', [OrderWaitingController::class, 'updateQuantity'])->name('order-waiting.update.quantity');
    Route::get('/order-waiting/{orderWaiting}/delete', [OrderWaitingController::class, 'delete'])->name('order-waiting.delete');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/orders/{provider}/save', [OrderController::class, 'save'])->name('orders.save');
    Route::get('/orders/{order}/delete', [OrderController::class, 'delete'])->name('orders.delete');
    Route::get('/orders/{order}/products', [OrderController::class, 'products'])->name('orders.products');

    // Unities
    Route::get('/unities', [UnityController::class, 'index'])->name('unities');
    Route::get('/unities/create', [UnityController::class, 'create'])->name('unities.create');
    Route::get('/unities/{unity}/edit', [UnityController::class, 'edit'])->name('unities.edit');
    Route::post('/unities/save', [UnityController::class, 'store'])->name('unities.store');
    Route::post('/unities/{unity}/update', [UnityController::class, 'update'])->name('unities.update');
    Route::get('/unities/{unity}/delete', [UnityController::class, 'destroy'])->name('unities.delete');

    // User
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/save', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/{user}/update', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{user}/delete', [UserController::class, 'destroy'])->name('users.delete');
    Route::post('/users/{user}/send-reset', SendUserPasswordResetController::class)->name('users.sendReset');

    // Tenant
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
    Route::post('/tenants/save', [TenantController::class, 'store'])->name('tenants.store');
    Route::post('/tenants/{tenant}/update', [TenantController::class, 'update'])->name('tenants.update');
    Route::get('/tenants/{tenant}/delete', [TenantController::class, 'destroy'])->name('tenants.delete');
});

require __DIR__.'/auth.php';
