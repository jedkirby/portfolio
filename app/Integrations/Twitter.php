<?php

namespace App\Integrations;

use Cache;
use App\Integrations\Twitter\Tweet;

class Twitter
{

    /**
     * @var string
     */
    const CACHE_NAME = 'tweet';

    /**
     * Create a tweet from a given array.
     *
     * @param array $tweet
     *
     * @return Tweet
     */
    public static function createFromArray(array $tweet)
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
     * Attempt to retrieve the tweet from the cache.
     *
     * @return Tweet|boolean
     */
    public static function getTweet()
    {
        return Cache::get(self::CACHE_NAME, false);
    }

    /**
     * Store tweet within the cache forever.
     *
     * @param Tweet $tweet
     *
     * @return void
     */
    public static function setTweet(Tweet $tweet)
    {
        Cache::forever(self::CACHE_NAME, $tweet);
    }

}
