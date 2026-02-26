<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;

Route::get('/product/{id}', [FrontendController::class, 'reletedProductsBySubcategory'])->name('frontend.show');
