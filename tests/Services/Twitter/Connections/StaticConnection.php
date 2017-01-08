<?php

namespace App\Tests\Services\Twitter\Connections;

use App\Services\Twitter\Connections\ConnectionInterface;
use App\Services\Twitter\TweetManager;

class StaticConnection implements ConnectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTimeline()
    {
        return [
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'First Tweet with #Hashtag',
                'entities' => [
                    'hashtags' => [
                        [
                            'text' => 'Hashtag',
                        ],
                    ],
                    'user_mentions' => [],
                    'urls' => [],
                ],
            ]),
            TweetManager::createFromArray([
                'id' => 2,
                'text' => 'Second Tweet',
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getTweetById($id)
    {
        return false;
    }
}
