<?php

namespace App\Tests\Domain\Service\Instagram\Connection\Provider\Fixtures;

use App\Domain\Service\Instagram\Connection\Provider\ProviderInterface;

class EmptyContent implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFeed()
    {
        return false;
    }
}
