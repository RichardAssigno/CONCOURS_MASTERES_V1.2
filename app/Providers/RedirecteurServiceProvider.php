<?php

namespace App\Providers;

use App\Services\RedirecteurService;
use Illuminate\Support\ServiceProvider;

class RedirecteurServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(RedirecteurService::class, function ($app) {
            return new RedirecteurService();
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
