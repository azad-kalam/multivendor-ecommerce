<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;


$adminMiddleware = ['auth', 'verified', RoleMiddleware::class . ':admin'];

Route::middleware($adminMiddleware)
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('profile', [AdminProfileController::class, 'index'])->name('profile.index');

        Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');

        Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
    });
