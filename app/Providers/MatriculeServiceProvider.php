<?php

namespace App\Providers;

use App\Services\MatriculeService;
use Illuminate\Support\ServiceProvider;

class MatriculeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->singleton(MatriculeService::class, function ($app) {
            return new MatriculeService();
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
