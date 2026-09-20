<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Observers\ProductObserver;

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
        Product::observe(ProductObserver::class);
        Paginator::useBootstrapFive();
        // السماح للمشرف الذي يحمل صلاحيات الإدارة الكاملة بتجاوز أي Policy
        Gate::before(function ($user, $ability) {
            return $user->hasRole('ولاء مشرف') ? true : null;
        });
    }
}
