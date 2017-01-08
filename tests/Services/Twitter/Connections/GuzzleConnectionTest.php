<?php

namespace App\Tests\Services\Twitter\Connections;

use App\Services\Twitter\Connections\GuzzleConnection;
use App\Services\Twitter\Connections\Providers\Guzzle;
use App\Services\Twitter\Entity\Tweet;
use App\Tests\AbstractTestCase;

class GuzzleConnectionTest extends AbstractTestCase
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
     * @return Guzzle
     */
    private function getProviderMock()
    {
        return $this->getMockBuilder(Guzzle::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @test
     * @group twitter
     */
    public function itCanGetTheTimeline()
    {
        $provider = $this->getProviderMock();
        $provider
            ->method('getTimeline')
            ->willReturn(
                $this->getSampleApiResponse('user-timeline')
            );

        $connection = new GuzzleConnection($provider);

        $timeline = $connection->getTimeline();

        $this->assertInternalType(
            'array',
            $timeline
        );

        $this->assertGreaterThan(
            0,
            count($timeline)
        );

        foreach ($timeline as $tweet) {
            $this->assertInstanceOf(
                Tweet::class,
                $tweet
            );
        }
    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnsAnEmptyArrayWhenThereAreNoTimelineResults()
    {
        $provider = $this->getProviderMock();
        $provider
            ->method('getTimeline')
            ->willReturn(false);

        $connection = new GuzzleConnection($provider);

        $timeline = $connection->getTimeline();

        $this->assertInternalType(
            'array',
            $timeline
        );

        $this->assertEmpty($timeline);
    }

    /**
     * @test
     * @group twitter
     */
    public function itCanGetTheTweetById()
    {
        $provider = $this->getProviderMock();
        $provider
            ->method('getTweetById')
            ->willReturn(
                $this->getSampleApiResponse('tweet')
            );

        $connection = new GuzzleConnection($provider);

        $tweet = $connection->getTweetById(1);

        $this->assertInstanceOf(
            Tweet::class,
            $tweet
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnsFalseForNoneExistentTweet()
    {
        $provider = $this->getProviderMock();
        $provider
            ->method('getTweetById')
            ->willReturn(false);

        $connection = new GuzzleConnection($provider);

        $this->assertFalse(
            $connection->getTweetById('--')
        );
    }
}
