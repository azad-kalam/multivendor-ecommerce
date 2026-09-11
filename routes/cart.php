<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\CartController;

Route::prefix('cart')->group(function () {
    Route::resource('/', CartController::class)->names('frontend.carts');
     Route::get('/shopping-cart', [CartController::class, 'ajax_shopping_cart'])->name('shopping-cart');
});
