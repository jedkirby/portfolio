<?php

namespace App\Tests\Services\Twitter\Connections;

use App\Services\Twitter\Connections\ConnectionInterface;

class NullConnection implements ConnectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTimeline()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getTweetById($id)
    {
        return false;
    }
}
