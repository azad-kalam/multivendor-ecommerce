<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;

// Route::get('/product/{id}', [FrontendController::class, 'reletedProductsBySubcategory'])->name('frontend.show');
Route::get('/product/{id}', [FrontendController::class, 'show_product_detailsWith_subcategory_related'])
    ->name('frontend.product_details.product_detailsWith_subcategory_related');

Route::get('/category/{id}/{name}', [FrontendController::class, 'category_wise_product_show'])
    ->name('frontend.category_wise_product_show');

Route::get('/subcategory/{id}/{name}', [FrontendController::class, 'subcategory_wise_product_show'])
    ->name('frontend.subcategory_wise_product_show');

Route::get('/brand/{name}', [FrontendController::class, 'brand_wise_product_show'])
    ->name('frontend.brand_wise_product_show');

// Route::get('/view-all/{slug}', [FrontendController::class, 'category_wise_view_all_product'])
//     ->name('frontend.view_all_products.category_wise_view_all_product');
