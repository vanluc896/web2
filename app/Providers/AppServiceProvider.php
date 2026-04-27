<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Cache;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // resources/views/client/partials/navbar.blade.php
        // View::composer('client.partials.navbar', function ($view) {
        //     $view->with([
        //         'categories' =>
        //         Category::select('catename', 'slug')
        //             ->orderBy('catename')->get(),
        //         'brands' => Brand::select('brandname', 'slug')
        //             ->orderBy('brandname')->get(),
        //     ]);
        // });

        View::composer('client.partials.navbar', function ($view) {
            $categories = Cache::remember('navbar_categories', 60, function () {
                return Category::select('catename', 'slug')
                    ->orderBy('catename')
                    ->get();
            });

            $brands = Cache::remember('navbar_brands', 60, function () {
                return Brand::select('brandname', 'slug')
                    ->orderBy('brandname')
                    ->get();
            });

            $view->with(compact('categories', 'brands'));
        });
    }
}
