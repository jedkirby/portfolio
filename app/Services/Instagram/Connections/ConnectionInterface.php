<?php

namespace App\Services\Instagram\Connections;

use App\Services\Instagram\Entity\Post;

/**
 * @codeCoverageIgnore
 */
interface ConnectionInterface
{
    /**
     * Return a users instagram feed.
     *
     * @return Post[]
     */
    public function getFeed();
}
