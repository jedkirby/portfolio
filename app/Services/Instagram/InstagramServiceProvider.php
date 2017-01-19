<?php

namespace App\Services\Instagram;

use App\Services\Instagram\Connections\Connection;
use App\Services\Instagram\Connections\Providers\Guzzle as GuzzleProvider;
use Config;
use Illuminate\Support\ServiceProvider;

/**
 * @codeCoverageIgnore
 */
class InstagramServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @codeCoverageIgnore
     */
    public function register()
    {
        $this->app->singleton(
            InstagramService::class,
            function () {
                return new InstagramService(
                    new Connection(
                        new GuzzleProvider(
                            Config::get('site.social.streams.instagram.api.access_token')
                        )
                    )
                );
            }
        );

        $this->app->singleton(
            InstagramManager::class,
            function () {
                return new InstagramManager();
            }
        );
    }
}
