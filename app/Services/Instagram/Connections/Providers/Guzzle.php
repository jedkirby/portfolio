<?php

namespace App\Services\Instagram\Connections\Providers;

use Config;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use Log;

/**
 * @codeCoverageIgnore
 */
class Guzzle implements ProviderInterface
{

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @param string $accessToken
     * @param string $baseUri
     */
    public function __construct(
        $accessToken,
        $baseUri = 'https://api.instagram.com/v1/'
    ) {
        $this->accessToken = $accessToken;
        $this->baseUri = $baseUri;
    }

    /**
     * @return GuzzleClient
     */
    private function getClient()
    {
        return new GuzzleClient([
            'base_uri' => $this->baseUri
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getFeed()
    {

        try {

            $response = $this->getClient()->get(
                sprintf(
                    'users/%s/media/recent.json',
                    Config::get('site.social.streams.instagram.id')
                ),
                [
                    'query' => [
                        'access_token' => $this->accessToken
                    ],
                ]
            );

            if (!in_array($response->getStatusCode(), [200])) {
                return false;
            }

            $data = json_decode($response->getBody(), true);

            if ($data && is_array($data)) {
                if (array_key_exists('data', $data)) {
                    return $data['data'];
                }
            }

        } catch (ClientException $e) {
            Log::error($e);
        }

        return false;

    }


}
