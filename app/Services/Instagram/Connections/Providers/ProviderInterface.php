<?php

namespace App\Services\Instagram\Connections\Providers;

/**
 * @codeCoverageIgnore
 */
interface ProviderInterface
{
    /**
     * Return a users instagram feed.
     *
     * @return array|boolean
     */
    public function getFeed();
}
