<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\CartController;

Route::post('add-to-cart', [CartController::class, 'store'])->name('frontend.carts.store');
Route::post('shopping-cart', [CartController::class, 'show'])->name('frontend.carts.show');
Route::post('shopping-cart', [CartController::class, 'index'])->name('frontend.carts.index');

