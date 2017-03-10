<?php

namespace App\Tests\Services\Twitter\Connections;

use App\Services\Twitter\Connections\Connection;
use App\Services\Twitter\Connections\ConnectionInterface;
use App\Services\Twitter\Entity\Tweet;
use App\Tests\AbstractAppTestCase;
use App\Tests\Services\Twitter\Connections\Providers\Fixtures\EmptyContent as EmptyContentProvider;
use App\Tests\Services\Twitter\Connections\Providers\Fixtures\StaticContent as StaticContentProvider;

class ConnectionTest extends AbstractAppTestCase
{
    /**
     * @return ConnectionInterface
     */
    private function getConnectionWithProvider($provider)
    {
        return new Connection(
            new $provider()
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnsAnEmptyArrayForNoTimeline()
    {
        $timeline = $this->getConnectionWithProvider(EmptyContentProvider::class)->getTimeline();

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
    public function itReturnsFalseForNoSingleTweet()
    {
        $this->assertFalse(
            $this->getConnectionWithProvider(EmptyContentProvider::class)->getTweetById(1)
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnsTweetsForTimeline()
    {
        $timeline = $this->getConnectionWithProvider(StaticContentProvider::class)->getTimeline();

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
    public function itReturnsTweetForSingleTweet()
    {
        $id = 210462857140252672;
        $tweet = $this->getConnectionWithProvider(StaticContentProvider::class)->getTweetById($id);

        $this->assertInstanceOf(
            Tweet::class,
            $tweet
        );

        $this->assertEquals(
            $tweet->getId(),
            $id
        );
    }
}
