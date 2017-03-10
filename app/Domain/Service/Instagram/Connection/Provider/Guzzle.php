<?php

namespace App\Domain\Service\Instagram\Connection\Provider;

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
            'base_uri' => $this->baseUri,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getFeed()
    {
        try {
            $response = $this->getClient()->get(
                'users/self/media/recent',
                [
                    'query' => [
                        'access_token' => $this->accessToken,
                        'count' => 20,
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
