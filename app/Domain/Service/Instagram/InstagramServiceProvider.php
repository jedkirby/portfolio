<?php

namespace App\Domain\Service\Instagram;

use App\Domain\Service\Instagram\Connection\Connection;
use App\Domain\Service\Instagram\Connection\Provider\Guzzle as GuzzleProvider;
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
