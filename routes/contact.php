<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Vendor\ContactController as VendorContactController;

Route::middleware(['auth', 'verified', RoleMiddleware::class . ':vendor'])
    ->prefix('vendor')
    ->name('vendor.')
    ->group(function () {

        Route::get('/contact', [VendorContactController::class, 'index'])
            ->name('contact.index');
    });
