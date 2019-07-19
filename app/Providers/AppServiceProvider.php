<?php

declare(strict_types=1);

namespace OrderService\Providers;

use Illuminate\Support\ServiceProvider;
use OrderService\Repository\OrderRepository;
use OrderService\Repository\SpatieOrderRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(OrderRepository::class, SpatieOrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
