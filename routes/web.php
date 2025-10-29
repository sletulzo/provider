<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderWaitingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProfileController;
use App\Models\OrderWaiting;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Dashboard 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/save', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.delete');

    // Order waiting
    Route::post('/order-waiting/save', [OrderWaitingController::class, 'save'])->name('order-waiting.save');
    Route::get('/order-waiting/{orderWaiting}/delete', [OrderWaitingController::class, 'delete'])->name('order-waiting.delete');
});

require __DIR__.'/auth.php';
