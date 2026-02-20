<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
$adminMiddleware = (['auth', 'verified', RoleMiddleware::class . ':admin']);
Route::middleware($adminMiddleware)
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('profile', AdminProfileController::class)->names('profile');
    });
