<?php

namespace App\Providers;

use Dynamify\PhpSdk\Dynamify;
use Illuminate\Support\ServiceProvider;

class DynamifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(
            Dynamify::class,
            function ($app) {
                return Dynamify::make([
                    'access_token' => env('DYNAMIFY_ACCESS_TOKEN'),
                    'base_uri' => env('DYNAMIFY_BASE_URI', 'https://api.dynamify.io/1.0'),
                    // 'debug' => env('APP_DEBUG', false),
                ]);
            }
        );
    }
}
