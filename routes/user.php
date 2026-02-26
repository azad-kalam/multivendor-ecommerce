<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

// user routes start here
// Route::get('/user/dashboard', function () {
//     return view('user.dashboard');
// })->middleware(['auth', 'verified', 'roleAlias:user'])->name('user.dashboard');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})
    ->middleware(['auth', 'verified', 'role:user'])
    ->name('user.dashboard');

// user routes end here
