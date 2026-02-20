<?php

// namespace App\Providers;
// use Illuminate\Pagination\Paginator;
// use Illuminate\Support\ServiceProvider;
// class AppServiceProvider extends ServiceProvider
// {

//     public function register(): void {}


//     public function boot(): void
//     {
//         Paginator::useBootstrapFive();
//     }
// }


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $categories = Category::with('subcategories')->get();
            $view->with('categories', $categories);
        });

        Paginator::useBootstrapFive();
    }
}
