<?php

namespace App\Providers;

use App\Models\OrderItem;
use App\Observers\DecreaseProductQuantityObserver;
use Illuminate\Support\ServiceProvider;

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
        //
        OrderItem::observe(DecreaseProductQuantityObserver::class);

    }
}
