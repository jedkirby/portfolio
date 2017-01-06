<?php

namespace App\Services\Twitter;

use App\Services\Twitter\TwitterConnectionInterface;

class TwitterService
{

    /**
     * @var TwitterConnectionInterface
     */
    private $connection;

    /**
     * @param TwitterConnectionInterface $connection
     */
    public function __construct(TwitterConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return TwitterConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

}
