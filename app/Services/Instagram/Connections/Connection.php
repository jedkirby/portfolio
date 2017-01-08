<?php

namespace App\Services\Instagram\Connections;

use App\Services\Instagram\Connections\Providers\ProviderInterface;
use App\Services\Instagram\InstagramManager;

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
