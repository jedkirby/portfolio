<?php

namespace App\Services\Twitter;

use App\Services\Twitter\Connections\GuzzleConnection;
use App\Services\Twitter\Connections\Providers\Guzzle as GuzzleProvider;
use Config;
use Illuminate\Support\ServiceProvider;

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
     *
     * @codeCoverageIgnore
     */
    public function register()
    {
        $this->app->singleton(
            TwitterService::class,
            function () {
                return new TwitterService(
                    new GuzzleConnection(
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
