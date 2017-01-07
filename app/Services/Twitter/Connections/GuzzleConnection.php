<?php

namespace App\Services\Twitter\Connections;

use App\Services\Twitter\Connections\Providers\Guzzle;
use App\Services\Twitter\TweetManager;

class GuzzleConnection implements ConnectionInterface
{
    /**
     * @var Guzzle
     */
    private $provider;

    /**
     * @param Guzzle $provider
     */
    public function __construct(Guzzle $provider)
    {
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeline()
    {
        $timeline = [];

        if ($response = $this->provider->getTimeline()) {
            foreach ($response as $tweet) {
                $timeline[] = TweetManager::createFromArray($tweet);
            }
        }

        return $timeline;
    }

    /**
     * {@inheritdoc}
     */
    public function getTweetById($id)
    {
        if ($tweet = $this->provider->getTweetById($id)) {
            return TweetManager::createFromArray($tweet);
        }

        return false;
    }
}
