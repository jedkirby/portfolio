<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        $this->registerNewRelic();
    }

    /**
     * Register the New Relic handler.
     */
    public function registerNewRelic()
    {
        if (extension_loaded('newrelic')) {
            if (($host = env('NR_HOST')) && ($key = env('NR_KEY'))) {
                newrelic_set_appname($host, $key);
            }
        }
    }
}
