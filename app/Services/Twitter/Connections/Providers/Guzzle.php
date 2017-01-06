<?php

namespace App\Services\Twitter\Connections\Providers;

use Log;
use Config;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack as GuzzleHandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1 as GuzzleAuth;

class Guzzle
{

    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @var string
     */
    private $consumerSecret;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $tokenSecret;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @param string $consumerKey
     * @param string $consumerSecret
     * @param string $token
     * @param string $tokenSecret
     * @param string $baseUri
     */
    public function __construct(
        $consumerKey,
        $consumerSecret,
        $token,
        $tokenSecret,
        $baseUri = 'https://api.twitter.com/1.1/'
    ) {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->token = $token;
        $this->tokenSecret = $tokenSecret;
        $this->baseUri = $baseUri;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return GuzzleClient
     */
    private function getClient()
    {

        $middleware = new GuzzleAuth([
            'consumer_key' => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
            'token' => $this->token,
            'token_secret' => $this->tokenSecret
        ]);

        $stack = GuzzleHandlerStack::create();
        $stack->push($middleware);

        return new GuzzleClient([
            'base_uri' => $this->baseUri,
            'handler' => $stack
        ]);

    }

    /**
     * @codeCoverageIgnore
     *
     * @return boolean|array
     */
    public function getTimeline()
    {

        try {

            $response = $this->getClient()->get(
                'statuses/user_timeline.json',
                [
                    'auth' => 'oauth',
                    'query' => [
                        'screen_name' => Config::get('site.social.streams.twitter.name'),
                        'count' => 200,
                        'trim_user' => true,
                        'exclude_replies' => true,
                        'contributor_details' => false,
                        'include_rts' => false
                    ]
                ]
            );

            return $this->decodeResponse($response);

        } catch (ClientException $e) {
            Log::error($e);
        }

        return false;

    }

    /**
     * @codeCoverageIgnore
     *
     * @param int $id
     * @return boolean|array
     */
    public function getTweetById($id)
    {

        try {

            $response = $this->getClient()->get(
                'statuses/show.json',
                [
                    'auth' => 'oauth',
                    'query' => [
                        'id' => $id,
                        'trim_user' => true,
                        'include_my_retweet' => false
                    ]
                ]
            );

            return $this->decodeResponse($response);

        } catch (ClientException $e) {
            Log::error($e);
        }

        return false;

    }

    /**
     * @param Response $response
     *
     * @return boolean|array
     */
    public function decodeResponse(Response $response)
    {

        if (!in_array($response->getStatusCode(), [200])) {
            return false;
        }

        $data = json_decode($response->getBody(), true);

        if ($data && is_array($data)) {
            return $data;
        }

        return false;

    }

}
