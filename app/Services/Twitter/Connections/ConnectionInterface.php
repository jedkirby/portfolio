<?php

namespace App\Services\Twitter\Connections;

use App\Services\Twitter\Entity\Tweet;

/**
 * @codeCoverageIgnore
 */
interface ConnectionInterface
{
    /**
     * Return a users home timeline.
     *
     * @return Tweet[]
     */
    public function getTimeline();

    /**
     * Return a single tweet by it's ID.
     *
     * @param int $id
     *
     * @return Tweet
     */
    public function getTweetById($id);
}
