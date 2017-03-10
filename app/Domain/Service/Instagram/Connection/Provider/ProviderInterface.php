<?php

namespace App\Domain\Service\Instagram\Connection\Provider;

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
