<?php

namespace App\Tests\Services\Twitter\Connections\Providers\Fixtures;

use App\Services\Twitter\Connections\Providers\ProviderInterface;

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
