<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        // Si en vez de 'partials.menu' ponemos '*' $categories sería una variable global
        View::composer('partials.menu', function ($view) { 
            $view->with('categories', Category::orderBy('name')->get());
        });
    }
}
