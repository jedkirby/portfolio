<?php

namespace App\Services\Twitter;

use App\Services\Twitter\Tweet;

interface TwitterConnectionInterface
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
