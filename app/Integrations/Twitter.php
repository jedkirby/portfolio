<?php

namespace App\Integrations;

use Cache;
use App\Integrations\Twitter\Tweet;

class Twitter
{

    /**
     * Cache Namespace
     */
    const CACHE_NAME = 'tweet';

    /**
     * Create a tweet from a given array.
     *
     * @param  array  $tweet
     * @return Tweet
     */
    public static function createTweetFromArray(array $tweet)
    {
        return Tweet::make(
            array_get($tweet, 'id'),
            array_get($tweet, 'text', ''),
            array_get($tweet, 'retweet_count', 0),
            array_get($tweet, 'favorite_count', 0),
            array_get($tweet, 'place.full_name', false)
        );
    }

    /**
     * Store tweet within the cache forever.
     *
     * @param  Tweet  $tweet
     * @return void
     */
    public static function storeTweet(Tweet $tweet)
    {
        Cache::forever(self::CACHE_NAME, $tweet);
    }

    /**
     * Attempt to retrieve the tweet from the cache.
     *
     * @return Tweet|boolean
     */
    public static function getLatest()
    {
        return Cache::get(self::CACHE_NAME, false);
    }

}
