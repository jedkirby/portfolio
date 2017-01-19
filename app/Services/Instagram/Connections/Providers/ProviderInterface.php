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
     * @return array|bool
     */
    public function getFeed();
}
