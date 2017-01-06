<?php

namespace App\Integrations\Twitter;

use Config;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack as GuzzleHandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1 as GuzzleAuth;

class Connection
{

    /**
     * @var GuzzleClient
     */
    private $client;

    public static function make()
    {
        return new self();
    }

    private function __construct()
    {

        $middleware = new GuzzleAuth([
            'consumer_key'    => Config::get('site.social.streams.twitter.api.consumer_key'),
            'consumer_secret' => Config::get('site.social.streams.twitter.api.consumer_secret'),
            'token'           => Config::get('site.social.streams.twitter.api.token'),
            'token_secret'    => Config::get('site.social.streams.twitter.api.token_secret')
        ]);

        $stack = GuzzleHandlerStack::create();
        $stack->push($middleware);

        $this->client = new GuzzleClient([
            'base_uri' => 'https://api.twitter.com/1.1/',
            'handler'  => $stack
        ]);

    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->client, $method), $args);
    }

}
