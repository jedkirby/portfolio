<?php

namespace App\Services\Instagram;

use App\Services\Instagram\Entity\Post;
use App\Services\Instagram\Exceptions\UnableToGetInstagramFeedPostsException;
use Cache;
use Config;

class InstagramManager
{
    /**
     * @var string
     */
    const CACHE_NAME = 'services.instagram';

    /**
     * Create a post from a given array.
     *
     * @param array $post
     *
     * @return Post
     */
    public static function createFromArray(array $post)
    {
        return Post::make(
            array_get($post, 'id'),
            array_get($post, 'link'),
            array_get($post, 'images.low_resolution.url'),
            array_get($post, 'caption.text', false)
        );
    }

    /**
     * Return all posts stored within the cache.
     *
     * @return Post[]|bool
     */
    public static function getPosts()
    {
        return Cache::get(self::CACHE_NAME, false);
    }

    /**
     * Store posts within the cache forever.
     *
     * @param array $posts
     */
    public static function setPosts(array $posts)
    {
        Cache::forever(self::CACHE_NAME, $posts);
    }

    /**
     * Clear the cache.
     */
    public static function clearCache()
    {
        Cache::forget(self::CACHE_NAME);
    }

    /**
     * @param array $feed
     * @param bool $limit
     * @param array $ignoredIds
     *
     * @throws UnableToGetInstagramFeedPostsException
     *
     * @return array
     */
    public static function getAllowedPosts(array $feed, $limit = false, $ignoredIds = [])
    {
        $posts = [];

        foreach ($feed as $post) {
            if (!in_array($post->getId(), $ignoredIds)) {
                $posts[] = $post;
            }
        }

        if (!$posts) {
            throw new UnableToGetInstagramFeedPostsException('Unable to get allowed Instagram feed posts.');
        }

        return $limit ? array_slice($posts, 0, $limit) : $posts;
    }

    /**
     * @return array
     */
    public static function getIgnoredIds()
    {
        return Config::get('site.social.streams.instagram.ignore', []);
    }
}
