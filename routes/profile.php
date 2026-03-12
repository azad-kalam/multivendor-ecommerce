<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Vendor\ProfileController as VendorProfileController;

$roles = [
    'admin' => AdminProfileController::class,
    'vendor' => VendorProfileController::class,
];

foreach ($roles as $role => $controller) {

    Route::middleware(['auth', 'verified', RoleMiddleware::class . ':' . $role])
        ->prefix($role)
        ->name($role . '.')
        ->group(function () use ($controller) {

            Route::controller($controller)->group(function () {

                Route::get('/profile', 'index')->name('profile.index');

                Route::get('/profile/edit', 'edit')->name('profile.edit');

                Route::put('/profile/update', 'update')->name('profile.update');

                Route::get('/profile/change-password', 'changePassword')
                    ->name('profile.change-password');

                Route::post('/profile/change-password', 'updatePassword')
                    ->name('profile.update-password');

                Route::post('/profile/email-notification/update', 'updateEmailNotification')
                    ->name('profile.email.notification.update');
            });
        });
}
