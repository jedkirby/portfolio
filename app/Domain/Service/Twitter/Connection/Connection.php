<?php

namespace App\Domain\Service\Twitter\Connection;

use App\Domain\Service\Twitter\Connection\Provider\ProviderInterface;
use App\Domain\Service\Twitter\TweetManager;

class Connection implements ConnectionInterface
{
    /**
     * @var ProviderInterface
     */
    private $provider;

    /**
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
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
