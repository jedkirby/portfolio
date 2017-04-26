<?php

namespace App\Domain\Service\Twitter;

use App\Domain\Service\Twitter\Connection\Connection;
use App\Domain\Service\Twitter\Connection\Provider\Guzzle as GuzzleProvider;
use Config;
use Illuminate\Support\ServiceProvider;

/**
 * @codeCoverageIgnore
 */
class TwitterServiceProvider extends ServiceProvider
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
            TwitterService::class,
            function () {
                return new TwitterService(
                    new Connection(
                        new GuzzleProvider(
                            Config::get('site.social.streams.twitter.api.consumer_key'),
                            Config::get('site.social.streams.twitter.api.consumer_secret'),
                            Config::get('site.social.streams.twitter.api.token'),
                            Config::get('site.social.streams.twitter.api.token_secret')
                        )
                    )
                );
            }
        );

        $this->app->singleton(
            TweetManager::class,
            function () {
                return new TweetManager();
            }
        );
    }
}
