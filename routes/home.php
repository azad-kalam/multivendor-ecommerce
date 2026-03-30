<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;

// home page access all visitors no need login or registration
Route::get('/', [HomeController::class, 'index'])->name('homepage.index');
Route::get('/category/{id}', [HomeController::class, 'productShowByCategory'])->name('homepage.product_by_category');
