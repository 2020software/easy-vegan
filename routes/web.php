<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/products', [ProductController::class, 'displayProduct'])->name('products');

Route::get('/products/details/{id}/{slug}', [ProductController::class, 'detailsProduct']);

Route::prefix('admin')->group(function () {
    Route::get('/', function () { return view('admin'); })->name('admin');
    Route::get('/add-product', [ProductController::class, 'addProduct'])->name('add-product');

    Route::post('/store', [ProductController::class, 'storeProduct'])->name('store-product');
    Route::get('/manage', [ProductController::class, 'manageProduct'])->name('manage-product');
    Route::get('/edit/{id}', [ProductController::class, 'editProduct'])->name('edit-product');
    Route::post('/data/update', [ProductController::class, 'updateProduct'])->name('update-product');
    Route::get('/delete/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');
    Route::post('/images/update', [ProductController::class, 'updateImages'])->name('update-images');
    Route::get('/images/delete/{id}', [ProductController::class, 'deleteImages'])->name('delete-images');
    Route::post('/thambnail/update', [ProductController::class, 'updateThambnail'])->name('update-thambnail');
});

Route::post('/cart/{id}', [CartController::class, 'addCart']);  // cart

Route::group(['prefix' => 'user', 'middleware' => ['user', 'auth']], function () {
    Route::get('/mycart', [CartController::class, 'myCart'])->name('my-cart');
    Route::get('/get-cart-product', [CartController::class, 'getCartProduct']);
    Route::get('/cart-remove/{rorId}', [CartController::class, 'removeCartProduct']);
});

// お会計
Route::get('/accounting', [CartController::class, 'accounting'])->name('accounting');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/verification', [VerificationController::class, 'verificationOrder'])->name('verification');