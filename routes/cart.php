<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEnd\CartController;

Route::post('add-to-cart', [CartController::class, 'store'])->name('frontend.carts.store');
Route::post('add-to-cart', [CartController::class, 'store'])->name('frontend.carts.store');
