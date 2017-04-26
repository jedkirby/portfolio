<?php

namespace App\Domain\Service\Twitter;

use App\Domain\Service\Twitter\Entity\Tweet;
use App\Domain\Service\Twitter\Exception\UnableToGetLatestTweetException;
use Cache;
use Config;

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
                    'urls' => [],
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
    public function getAllowedHashtags()
    {
        return Config::get('site.social.streams.twitter.hashtags', []);
    }

    /**
     * Attempt to retrieve the tweet from the cache.
     *
     * @return Tweet|bool
     */
    public function getTweet()
    {
        return Cache::get(self::CACHE_NAME, false);
    }

    /**
     * Store tweet within the cache forever.
     *
     * @param Tweet $tweet
     */
    public function setTweet(Tweet $tweet)
    {
        Cache::forever(self::CACHE_NAME, $tweet);
    }

    /**
     * Clear the cache.
     */
    public function clearCache()
    {
        Cache::forget(self::CACHE_NAME);
    }

    /**
     * @param array $timeline
     * @param array $allowedHashtags
     *
     * @throws UnableToGetLatestTweetException
     *
     * @return Tweet
     */
    public function getLatestTweet(array $timeline = [], array $allowedHashtags = [])
    {
        foreach ($timeline as $tweet) {
            foreach ($tweet->getHashtags() as $hashtag) {
                if (in_array(strtolower(array_get($hashtag, 'text')), array_map('strtolower', $allowedHashtags))) {
                    return $tweet;
                }
            }
        }

        throw new UnableToGetLatestTweetException('No relevant tweet found.');
    }

    /**
     * @param Tweet $tweet
     *
     * @return bool
     */
    public function hasTweetChanged(Tweet $tweet)
    {
        if ($storedTweet = self::getTweet()) {
            return $storedTweet->getId() !== $tweet->getId();
        }

        return true;
    }
}
