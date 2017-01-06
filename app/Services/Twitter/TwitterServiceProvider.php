<?php

namespace App\Services\Twitter;

use Config;
use Illuminate\Support\ServiceProvider;
use App\Services\Twitter\TwitterService;
use App\Services\Twitter\Connections\GuzzleConnection;
use App\Services\Twitter\Connections\Providers\Guzzle as GuzzleProvider;

class TwitterServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
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

    }

}
