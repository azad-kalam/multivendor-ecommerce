<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\CartController;

Route::prefix('cart')->name('frontend.carts.')->group(function () {

    Route::get('/', [CartController::class, 'index'])->name('index');

    Route::post('/', [CartController::class, 'store'])->name('store');

    Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');

    Route::get('/shopping-cart', [CartController::class, 'ajax_cart_and_summary'])->name('shopping-cart');
});
