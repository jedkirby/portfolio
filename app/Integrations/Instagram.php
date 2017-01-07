<?php

namespace App\Integrations;

use App\Integrations\Instagram\Post;
use Cache;

class Instagram
{
    /**
     * Cache Namespace.
     */
    const CACHE_NAME = 'instagram';

    /**
     * Create a post from a given array.
     *
     * @param  array  $post
     *
     * @return Post
     */
    public static function createPostFromArray(array $post)
    {
        return Post::make(
            array_get($post, 'id'),
            array_get($post, 'link'),
            array_get($post, 'images.low_resolution.url'),
            array_get($post, 'caption.text', false)
        );
    }

    /**
     * Store posts within the cache forever.
     *
     * @param  array  $posts
     */
    public static function storePosts(array $posts)
    {
        Cache::forever(self::CACHE_NAME, $posts);
    }

    /**
     * Return all posts stored within the cache.
     *
     * @return array
     */
    public static function getPosts()
    {
        return Cache::get(self::CACHE_NAME, []);
    }
}
