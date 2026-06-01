<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // I using categories, sub-categories data in global views file
        View::composer([
            'inc.headers.admin.*',
            'inc.headers.vendor.*',
            'inc.headers.customer.*',
            'inc.headers.global.*',
            'inc.homepage.body.*'
        ], function ($view) {

            $gcategories_data = Cache::remember('categories_store_one_hour', 3600, function () {

                return Category::select('id', 'name')
                    ->with(['subcategories:id,category_id,subcategory_name'])
                    ->get();
            });

            $view->with('global_categories', $gcategories_data);
        });

        Paginator::useBootstrapFive();
    }
}
