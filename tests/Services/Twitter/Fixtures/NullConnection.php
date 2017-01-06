<?php

namespace Test\App\Services\Twitter\Fixtures;

use App\Services\Twitter\Connections\ConnectionInterface;

class NullConnection implements ConnectionInterface
{

    /**
     * {@inheritDoc}
     */
    public function getTimeline()
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getTweetById($id)
    {
        return false;
    }

}
