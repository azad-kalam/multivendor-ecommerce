<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RoleTypeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\LiveSearchController as AdminLiveSearchController;
use App\Http\Controllers\Admin\PaginationController;
use App\Http\Controllers\Admin\AllRegisterController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductModelController;
use App\Http\Controllers\Admin\SizeController;

// admin routes start here
$adminMiddleware = (['auth', 'verified', RoleMiddleware::class . ':admin']);
Route::middleware($adminMiddleware)
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // 1. all Dashboard admin + vendor + customer
        //Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // 2. all register + role type info admin + vendor + customer
        // all register type info [admin, vendor, customer]
        Route::resource('all-register', AllRegisterController::class)->names('all_register_info');
        // Admin Details CRUD
        Route::resource('details', AdminController::class)->names('details');

        // role type info [vendor]
        Route::get('vendors', [RoleTypeController::class, 'vendor'])->name('all_vendor.index');
        Route::get('vendors/{id}/edit', [RoleTypeController::class, 'vendor_edit'])->name('all_vendor.edit');
        Route::put('vendors/{id}', [RoleTypeController::class, 'vendor_update'])->name('all_vendor.update');
        Route::delete('vendors/{id}', [RoleTypeController::class, 'vendor_destroy'])->name('all_vendor.destroy');

        // role type info [user/customer]
        Route::get('users', [RoleTypeController::class, 'user'])->name('all_user.index');
        Route::get('users/{id}/edit', [RoleTypeController::class, 'user_edit'])->name('all_user.edit');
        Route::put('users/{id}', [RoleTypeController::class, 'user_update'])->name('all_user.update');
        Route::delete('users/{id}', [RoleTypeController::class, 'user_destroy'])->name('all_user.destroy');

        // 3. all CRUD
        // Categories CRUD
        Route::resource('categories', CategoryController::class)->names('categories.CRUD');
        // Subcategories CRUD
        Route::resource('subcategories', SubcategoryController::class)->names('sub_categories.CRUD');
        //banners CRUD
        Route::resource('banners', BannerController::class)->names('banners.CRUD');
        // brands CRUD
        Route::resource('brands', BrandController::class)->names('brands.CRUD');
        // colors CRUD
        Route::resource('colors', ColorController::class)->names('colors.CRUD');
        // model CRUD
        Route::resource('models', ProductModelController::class)->names('product_models.CRUD');
        // Sizes CRUD
        Route::resource('sizes', SizeController::class)->names('sizes.CRUD');
        // Products CRUD
        Route::resource('products', AdminProductController::class)->names('products.CRUD');

        // 4. all AJAX Live search
        // all register AJAX Live Search
        Route::get('register/search', [AdminLiveSearchController::class, 'allRegisterSearch'])->name('all_register_info.search');
        // Admin AJAX live search
        Route::get('search', [AdminLiveSearchController::class, 'adminSearch'])->name('details.search');
        // Vendor AJAX live search
        Route::get('vendor/search', [AdminLiveSearchController::class, 'vendorSearch'])->name('all_vendor.search');
        // User AJAX live search
        Route::get('user/search', [AdminLiveSearchController::class, 'userSearch'])->name('all_user.search');
        // Categories AJAX Live Search
        Route::get('category/search', [AdminLiveSearchController::class, 'categorySearch'])->name('categories.search');
        // Subcategories AJAX Live Search
        Route::get('subcategory/search', [AdminLiveSearchController::class, 'subcategorySearch'])->name('sub_categories.search');
        // Banner AJAX Live Search
        Route::get('banner/search', [AdminLiveSearchController::class, 'bannerSearch'])->name('banners.search');
        // Brand AJAX Live Search
        Route::get('brand/search', [AdminLiveSearchController::class, 'brandSearch'])->name('brands.search');
        // Color AJAX Live Search
        Route::get('color/search', [AdminLiveSearchController::class, 'colorSearch'])->name('colors.search');
        // model AJAX Live search
        Route::get('model/search', [AdminLiveSearchController::class, 'modelSearch'])->name('product_models.search');
        // Sizes AJAX Live Search
        Route::get('/size/search', [AdminLiveSearchController::class, 'sizeSearch'])->name('sizes.search');
        // Products AJAX Live Search
        Route::get('product/search', [AdminLiveSearchController::class, 'productSearch'])->name('products.search');

        // 5. all AJAX pagination
        // Categories AJAX Pagination
        Route::get('category/pagination', [PaginationController::class, 'categoryPagination']);
        // Subcategories AJAX Pagination
        Route::get('subcategory/pagination', [PaginationController::class, 'subcategoryPagination'])->name('sub_categories.pagination');

        // 6. all Dependency
        // Product Category Dependency (Dropdown)
        Route::get('product/category/{id}', [AdminProductController::class, 'dependentCategoryID'])->name('products.CRUD.dependentCategoryID');
        // product brand to model dependency
        Route::get('/get-models/{brand_id}', [AdminProductController::class, 'dependent_getModelsByBrand'])->name('products.CRUD.product_model_dependency');

        // 7. all status change
        // User Status
        Route::post('user/{id}', [AllRegisterController::class, 'user_status'])->name('user.status');
        // Banner Status
        Route::post('banner/{id}', [BannerController::class, 'status'])->name('banner.status');
        // Brand Status
        Route::post('brand/{id}', [BrandController::class, 'status'])->name('brand.status');
        // Color status
        Route::post('color/{id}', [ColorController::class, 'color_status'])->name('color.status');
        // model status
        Route::post('model/{id}', [ProductModelController::class, 'model_status'])->name('model.status');
        // size status
        Route::post('size/{id}', [SizeController::class, 'changeStatus'])->name('size.status');
        // Product Status
        Route::post('product/{id}', [AdminProductController::class, 'status'])->name('product.status');
    });
// admin routes end here
