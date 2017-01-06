<?php

namespace App\Services\Twitter;

use Cache;
use Config;
use App\Services\Twitter\Tweet;

class TweetManager
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
            array_get(
                $tweet, 
                'entities',
                [
                    'hashtags' => [],
                    'user_mentions' => [],
                    'urls' => []
                ]
            ),
            array_get($tweet, 'retweet_count', 0),
            array_get($tweet, 'favorite_count', 0),
            array_get($tweet, 'place.full_name', false)
        );
    }

    /**
     * @return array
     */
    public static function getAllowedHashtags()
    {
        return array_map(
            'strtolower',
            Config::get('site.social.streams.twitter.hashtags', [])
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

    /**
     * Clear the cache.
     *
     * @return void
     */
    public static function clearCache()
    {
        Cache::forget(self::CACHE_NAME);
    }

}
