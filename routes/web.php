<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

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

Route::get('/products', [ProductController::class, 'DisplayProduct'])->name('products');

Route::get('/products/details/{id}/{slug}', [ProductController::class, 'DetailsProduct']);

Route::prefix('admin')->group(function () {
    Route::get('/', function () { return view('admin'); })->name('admin');
    Route::get('/add-product', [ProductController::class, 'AddProduct'])->name('add-product');

    Route::post('/store', [ProductController::class, 'StoreProduct'])->name('store-product');
    Route::get('/manage', [ProductController::class, 'ManageProduct'])->name('manage-product');
    Route::get('/edit/{id}', [ProductController::class, 'EditProduct'])->name('edit-product');
    Route::post('/data/update', [ProductController::class, 'UpdateProduct'])->name('update-product');
    Route::get('/delete/{id}', [ProductController::class, 'DeleteProduct'])->name('delete-product');
    Route::post('/images/update', [ProductController::class, 'UpdateImages'])->name('update-images');
    Route::get('/images/delete/{id}', [ProductController::class, 'DeleteImages'])->name('delete-images');
    Route::post('/thambnail/update', [ProductController::class, 'UpdateThambnail'])->name('update-thambnail');
});

Route::post('/cart/{id}', [CartController::class, 'AddCart']);  // cart

Route::group(['prefix' => 'user', 'middleware' => ['user', 'auth']], function () {
    Route::get('/mycart', [CartController::class, 'MyCart'])->name('my-cart');
    Route::get('/get-cart-product', [CartController::class, 'GetCartProduct']);
    Route::get('/cart-remove/{rorId}', [CartController::class, 'RemoveCartProduct']);
});

// お会計
Route::get('/accounting', [CartController::class, 'Accounting'])->name('accounting');
Route::post('/checkout', [CheckoutController::class, 'Checkout'])->name('checkout');