<?php

namespace App\Domain\Service\Instagram\Connection;

use App\Domain\Service\Instagram\Connection\Provider\ProviderInterface;
use App\Domain\Service\Instagram\InstagramManager;

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
    public function getFeed()
    {
        $feed = [];

        if ($response = $this->provider->getFeed()) {
            foreach ($response as $post) {
                $feed[] = InstagramManager::createFromArray($post);
            }
        }

        return $feed;
    }
}
