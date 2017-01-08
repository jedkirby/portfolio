<?php

namespace App\Tests\Services\Instagram\Connections\Providers\Fixtures;

use App\Services\Instagram\Connections\Providers\ProviderInterface;

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
