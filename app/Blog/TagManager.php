<?php

namespace App\Blog;

use Exception;

class TagManager
{

    /**
     * Array of registered, and available, tag aliases to classes.
     *
     * @var array
     */
    private static $tags = [
        'mysql'         => Tags\Mysql::class,
        'digital-ocean' => Tags\DigitalOcean::class,
        'nginx'         => Tags\Nginx::class,
        'server-config' => Tags\ServerConfiguration::class
    ];

    /**
     * Get a specific tag using its alias.
     *
     * @param $alias string
     * @return \App\Blog\Contracts\Tag
     * @throws Exception
     */
    public static function get($alias)
    {

        $tag = array_get(static::$tags, $alias, false);

        if ($tag === false) {
            throw new Exception(sprintf('Unable to load the tag "%s".', $alias));
        }

        $tag = new $tag;

        if (!$tag instanceof Contracts\Tag) {
            throw new Exception(sprintf(
                'The loaded tag "%s" does not implement the "%s" contract.',
                $alias,
                Contracts\Tag::class
            ));
        }

        return new $tag;

    }

}
