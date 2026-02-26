<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\LiveSearchController as VendorLiveSearchController;

// vendor routes start here
$vendorMiddleware = ['auth', 'verified', RoleMiddleware::class . ':vendor'];
Route::middleware($vendorMiddleware)
    ->prefix('vendor')
    ->name('vendor.')
    ->group(function () {
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
        Route::resource('details', VendorController::class)->names('details');
        Route::resource('products', VendorProductController::class)->names('products');
        Route::get('product/{id}', [VendorProductController::class, 'status'])->name('product.status');
        Route::get('product/category/{id}', [VendorProductController::class, 'dependencyCategoryID'])->name('products.dependent_Category');

        Route::get('product/search', [VendorLiveSearchController::class, 'productSearch'])->name('products.search');
    });
// vendor routes end here
