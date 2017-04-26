<?php

namespace App\Domain\Service\Instagram;

use App\Domain\Service\Instagram\Connection\ConnectionInterface;

class InstagramService
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
