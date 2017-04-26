<?php

namespace App\Tests\Domain\Service\Instagram\Connection\Provider\Fixtures;

use App\Domain\Service\Instagram\Connection\Provider\ProviderInterface;

class StaticContent implements ProviderInterface
{
    /**
     * @param string $endpoint
     *
     * @return array
     */
    private function getSampleApiResponse($endpoint)
    {
        return json_decode(
            file_get_contents(
                sprintf(
                    __DIR__ . '/Fixtures/%s.json',
                    $endpoint
                )
            ),
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFeed()
    {
        return $this->getSampleApiResponse('feed');
    }
}
