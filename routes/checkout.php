<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\CheckoutController;

Route::prefix('frontend')
    ->name('frontend.')
    ->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])
            ->name('checkout.index');
        Route::get('/checkout', [CheckoutController::class, 'create'])
            ->name('checkout.create');

        Route::post('/checkout', [CheckoutController::class, 'store'])
            ->name('checkout.store');
        Route::post('/checkout', [CheckoutController::class, 'show'])
            ->name('checkout.show');
        Route::post('/checkout', [CheckoutController::class, 'edit'])
            ->name('checkout.edit');
        Route::delete('/checkout/id', [CheckoutController::class, 'delete'])
            ->name('checkout.delete');
    });
