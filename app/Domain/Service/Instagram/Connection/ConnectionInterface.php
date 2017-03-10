<?php

namespace App\Domain\Service\Instagram\Connection;

use App\Domain\Service\Instagram\Entity\Post;

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
