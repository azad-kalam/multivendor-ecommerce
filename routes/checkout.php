<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\CheckoutController;

Route::prefix('frontend')
    ->name('frontend.')
    ->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'create'])
            ->name('checkout.create');

        Route::post('/checkout', [CheckoutController::class, 'store'])
            ->name('checkout.store');
    });
