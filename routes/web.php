<?php

use App\Http\Controllers\Customers\CartController;
use App\Http\Controllers\Customers\CheckoutController;
use App\Http\Controllers\Customers\HistoryController;
use App\Http\Controllers\Customers\HomeController;
use App\Http\Controllers\Customers\ProductController;
use App\Http\Controllers\Staff\CategoryController;
use App\Http\Controllers\Staff\CustomerController;
use App\Http\Controllers\Staff\DashboardController;
use App\Http\Controllers\Staff\PackageController;
use App\Http\Controllers\Staff\TypeController;
use App\Http\Controllers\Staff\CarController;
use App\Http\Controllers\Staff\TransactionController;
use App\Http\Controllers\Owner\StaffController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(['as' => 'homepage.'], function () {
    Route::get('/shop', [ProductController::class, 'index'])->name('shop');
    Route::get('/detail-product/{id}', [ProductController::class, 'detail']);
});

// Route::middleware(['auth'])->group(function () {
Route::middleware(['auth', /*'checkRole:Customer'*/])->group(function () {
    Route::group(['as' => 'cart.'], function () {
        Route::get('/cart', [CartController::class, 'index'])->name('index');
        Route::post('/add-to-cart/{id}', [CartController::class, 'addCart'])->name('add');
        Route::get('/remove-from-cart/{id}', [CartController::class, 'destroy'])->name('remove');
        // Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
        Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
        Route::post('/cart/update-date', [CartController::class, 'updateDate'])->name('cart.updateDate');

    });
    Route::group(['as' => 'checkout.'], function () {
        Route::post('/checkout', [CheckoutController::class, 'index'])->name('index');
        Route::get('/invoice/{id}', [CheckoutController::class, 'invoice'])->name('invoice');
        // Route::post('/midtrans-callback', [CheckoutController::class, 'callback'])->name('callback');
        // Route::post('/checkout-data', [CheckoutController::class, 'store'])->name('store');
    });
    Route::group(['as' => 'history.'], function () {
        Route::get('/riwayat-order', [HistoryController::class, 'index'])->name('index');
        Route::get('/riwayat-detail/{id}', [HistoryController::class, 'detail'])->name('detail');
    });
});

Route::middleware(['auth'])->group(function () {
    // Route::middleware(['auth', 'checkRole:Staff'])->group(function () {
    Route::group(['as' => 'package.'], function () {
        Route::get('/data-package', [PackageController::class, 'index'])->name('index');
        Route::resource('package', PackageController::class);
        Route::delete('/package/image/delete/{id}', [PackageController::class, 'deleteImage']);
        // Route::post('/update-package/{id}', [PackageController::class, 'updateStatusPackage'])->name('updateStatusPackage');
    });
    Route::group(['as' => 'type.'], function () {
        Route::get('/data-type', [TypeController::class, 'index']);
        Route::resource('type', TypeController::class);
    });
    Route::group(['as' => 'transaction.'], function () {
        Route::get('/data-transaction', [TransactionController::class, 'index']);
        Route::resource('transaction', TransactionController::class);
    });
    Route::group(['as' => 'car.'], function () {
        Route::get('/data-car', [CarController::class, 'index']);
        Route::resource('car', CarController::class);
        Route::delete('/car/image/delete/{id}', [CarController::class, 'deleteImage']);
    });
    Route::group(['as' => 'owner.'], function () {
        Route::get('/data-staff', [StaffController::class, 'index']);
        Route::resource('users', StaffController::class);
        // Route::get('/users/{id}', [StaffController::class, 'show']);
    });
    
});

require __DIR__ . '/auth.php';
