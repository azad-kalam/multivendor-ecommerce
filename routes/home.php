<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;

// home page access all visitors no need login or registration
Route::get('/', [HomeController::class, 'index'])->name('homepage.index');
