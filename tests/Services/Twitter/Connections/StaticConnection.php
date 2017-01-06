<?php

namespace Test\App\Services\Twitter\Connections;

use App\Services\Twitter\TweetManager;
use App\Services\Twitter\Connections\ConnectionInterface;

class StaticConnection implements ConnectionInterface
{

    /**
     * {@inheritDoc}
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
                            'text' => "Hashtag"
                        ]
                    ],
                    'user_mentions' => [],
                    'urls' => []
                ]
            ]),
            TweetManager::createFromArray([
                'id' => 2,
                'text' => 'Second Tweet'
            ])
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getTweetById($id)
    {
        return false;
    }

}
