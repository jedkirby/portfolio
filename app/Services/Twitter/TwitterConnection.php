<?php

namespace App\Services\Twitter;

use Log;
use Config;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack as GuzzleHandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1 as GuzzleAuth;
use App\Services\Twitter\TwitterConnectionInterface;
use App\Services\Twitter\TweetManager;

class TwitterConnection implements TwitterConnectionInterface
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
     * @return GuzzleClient
     */
    public function getClient()
    {

        $middleware = new GuzzleAuth([
            'consumer_key'    => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
            'token'           => $this->token,
            'token_secret'    => $this->tokenSecret
        ]);

        $stack = GuzzleHandlerStack::create();
        $stack->push($middleware);

        return new GuzzleClient([
            'base_uri' => $this->baseUri,
            'handler'  => $stack
        ]);

    }

    /**
     * @param Response $response
     *
     * @return boolean|array
     */
    private function getDecodedResponse(Response $response)
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

    /**
     * {@inheritDoc}
     */
    public function getTimeline()
    {

        $timeline = [];

        try {

            $response = $this->getClient()->get(
                'statuses/user_timeline.json',
                [
                    'auth' => 'oauth',
                    'query' => [
                        'screen_name'         => Config::get('site.social.streams.twitter.name'),
                        'count'               => Config::get('site.social.streams.twitter.limit', 200),
                        'trim_user'           => true,
                        'exclude_replies'     => true,
                        'contributor_details' => false,
                        'include_rts'         => false
                    ]
                ]
            );

            $tweets = $this->getDecodedResponse($response);

            if ($tweets) {
                foreach ($tweets as $tweet) {
                    $timeline[] = TweetManager::createFromArray($tweet);
                }
            }

        } catch (ClientException $e) {
            Log::error($e);
        }

        return $timeline;

    }

    /**
     * {@inheritDoc}
     */
    public function getTweetById($id)
    {

        try {

            $response = $this->getClient()->get(
                'statuses/show.json',
                [
                    'auth' => 'oauth',
                    'query' => [
                        'id'                 => $id,
                        'trim_user'          => true,
                        'include_my_retweet' => false
                    ]
                ]
            );

            if ($tweet = $this->getDecodedResponse($response)) {
                return TweetManager::createFromArray($tweet);
            }

        } catch (ClientException $e) {
            Log::error($e);
        }

        return false;

    }

}
