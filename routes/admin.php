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

// admin routes start here
// Route::middleware(['auth', 'verified', 'roleAlias:admin'])
$adminMiddleware = (['auth', 'verified', RoleMiddleware::class . ':admin']);
Route::middleware($adminMiddleware)
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        //Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // all register type info [admin, vendor, customer]
        Route::resource('all-register', AllRegisterController::class)->names('all_register_info');
        // Admin Details CRUD
        Route::resource('details', AdminController::class)->names('details');

        // all role type info [vendor]
        Route::get('vendors', [RoleTypeController::class, 'vendor'])->name('all_vendor.index');
        Route::get('vendors/{id}/edit', [RoleTypeController::class, 'vendor_edit'])->name('all_vendor.edit');
        Route::put('vendors/{id}', [RoleTypeController::class, 'vendor_update'])->name('all_vendor.update');
        Route::delete('vendors/{id}', [RoleTypeController::class, 'vendor_destroy'])->name('all_vendor.destroy');

        // all role type info [user/customer]
        Route::get('users', [RoleTypeController::class, 'user'])->name('all_user.index');
        Route::get('users/{id}/edit', [RoleTypeController::class, 'user_edit'])->name('all_user.edit');
        Route::put('users/{id}', [RoleTypeController::class, 'user_update'])->name('all_user.update');
        Route::delete('users/{id}', [RoleTypeController::class, 'user_destroy'])->name('all_user.destroy');

        // Categories CRUD
        Route::resource('categories', CategoryController::class)->names('categories.CRUD');
        // Subcategories CRUD
        Route::resource('subcategories', SubcategoryController::class)->names('sub_categories.CRUD');
        // Products CRUD
        Route::resource('products', AdminProductController::class)->names('products.CRUD');

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
        // Products AJAX Live Search
        Route::get('product/search', [AdminLiveSearchController::class, 'productSearch'])->name('products.search');

        // Categories AJAX Pagination
        Route::get('category/pagination', [PaginationController::class, 'categoryPagination']);
        // Subcategories AJAX Pagination
        Route::get('subcategory/pagination', [PaginationController::class, 'subcategoryPagination'])->name('sub_categories.pagination');

        // Product Category Dependency (Dropdown)
        Route::get('product/category/{id}', [AdminProductController::class, 'dependentCategoryID'])->name('products.CRUD.dependentCategoryID');
        // Product Status
        Route::post('product/{id}', [AdminProductController::class, 'status'])->name('product.status');
        // User Status
        Route::post('user/{id}', [AllRegisterController::class, 'user_status'])->name('user.status');
    });
// admin routes end here
