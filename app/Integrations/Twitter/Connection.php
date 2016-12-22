<?php

namespace App\Integrations\Twitter;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack as GuzzleHandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1 as GuzzleAuth;

class Connection
{

    private $stack;

    private $middleware;

    private $client;

    public function __construct($consumerKey, $consumerSecret, $token, $tokenSecret)
    {
        
        $this->middleware = new GuzzleAuth([
            'consumer_key' => $consumerKey,
            'consumer_secret' => $consumerSecret,
            'token' => $token,
            'token_secret' => $tokenSecret
        ]);

        $this->stack = GuzzleHandlerStack::create();
        $this->stack->push($this->middleware);

    }

    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new GuzzleClient([
                'base_uri' => 'https://api.twitter.com/1.1/',
                'handler' => $this->stack
            ]);
        }
        return $this->client;
    }

}
