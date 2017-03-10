<?php

namespace App\Tests\Domain\Service\Twitter\Connection\Provider\Fixtures;

use App\Domain\Service\Twitter\Connection\Provider\ProviderInterface;

class EmptyContent implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTimeline()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getTweetById($id)
    {
        return false;
    }
}
