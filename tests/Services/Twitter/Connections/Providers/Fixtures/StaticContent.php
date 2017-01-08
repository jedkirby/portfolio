<?php

namespace App\Tests\Services\Twitter\Connections\Providers\Fixtures;

use App\Services\Twitter\Connections\Providers\ProviderInterface;

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
    public function getTimeline()
    {
        return $this->getSampleApiResponse('user-timeline');
    }

    /**
     * {@inheritdoc}
     */
    public function getTweetById($id)
    {
        return $this->getSampleApiResponse('tweet');
    }
}
