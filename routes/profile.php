<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Vendor\ProfileController as VendorProfileController;

Route::middleware(['auth', 'verified', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/profile', [AdminProfileController::class, 'index'])
            ->name('profile.index');

        Route::get('/profile/edit', [AdminProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile/update', [AdminProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::post('/profile/change-password', [AdminProfileController::class, 'updatePassword'])->name('profile.update-password');
    });

    Route::middleware(['auth', 'verified', RoleMiddleware::class . ':vendor'])
    ->prefix('vendor')
    ->name('vendor.')
    ->group(function () {

        Route::get('/profile', [VendorProfileController::class, 'index'])
            ->name('profile.index');

        Route::get('/profile/edit', [VendorProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile/update', [VendorProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('/profile/change-password', [VendorProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::post('/profile/change-password', [VendorProfileController::class, 'updatePassword'])->name('profile.update-password');
    });
