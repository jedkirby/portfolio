<?php

namespace App\Domain;

use Illuminate\Config\Repository as Config;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(
            Domain::class,
            function ($app) {
                return new Domain(
                    $app->make(Config::class)
                );
            }
        );
    }
}
