<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

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
    });
