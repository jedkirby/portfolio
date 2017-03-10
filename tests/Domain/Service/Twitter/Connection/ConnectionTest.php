<?php

namespace App\Tests\Domain\Service\Twitter\Connection;

use App\Domain\Service\Twitter\Connection\Connection;
use App\Domain\Service\Twitter\Entity\Tweet;
use App\Tests\AbstractTestCase as TestCase;
use App\Tests\Domain\Service\Twitter\Connection\Provider\Fixtures\EmptyContent as EmptyContentProvider;
use App\Tests\Domain\Service\Twitter\Connection\Provider\Fixtures\StaticContent as StaticContentProvider;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.twitter
 * @group domain.service.twitter.connection
 */
class ConnectionTest extends TestCase
{
    private function getConnectionWithProvider($provider)
    {
        return new Connection(
            new $provider()
        );
    }

    public function testItReturnsAnEmptyArrayForNoTimeline()
    {
        $timeline = $this->getConnectionWithProvider(EmptyContentProvider::class)->getTimeline();

        $this->assertInternalType(
            'array',
            $timeline
        );

        $this->assertEmpty($timeline);
    }

    public function testItReturnsFalseForNoSingleTweet()
    {
        $this->assertFalse(
            $this->getConnectionWithProvider(EmptyContentProvider::class)->getTweetById(1)
        );
    }

    public function testItReturnsTweetsForTimeline()
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

    public function testItReturnsTweetForSingleTweet()
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
