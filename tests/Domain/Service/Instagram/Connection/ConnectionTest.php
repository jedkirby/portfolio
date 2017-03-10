<?php

namespace App\Tests\Domain\Service\Instagram\Connection;

use App\Domain\Service\Instagram\Connection\Connection;
use App\Domain\Service\Instagram\Entity\Post;
use App\Tests\AbstractTestCase as TestCase;
use App\Tests\Domain\Service\Instagram\Connection\Provider\Fixtures\EmptyContent as EmptyContentProvider;
use App\Tests\Domain\Service\Instagram\Connection\Provider\Fixtures\StaticContent as StaticContentProvider;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.instagram
 * @group domain.service.instagram.connection
 */
class ConnectionTest extends TestCase
{
    private function getConnectionWithProvider($provider)
    {
        return new Connection(
            new $provider()
        );
    }

    public function testItReturnsAnEmptyArrayForNoFeed()
    {
        $feed = $this->getConnectionWithProvider(EmptyContentProvider::class)->getFeed();

        $this->assertInternalType(
            'array',
            $feed
        );

        $this->assertEmpty($feed);
    }

    public function testItReturnsPostsForFeed()
    {
        $feed = $this->getConnectionWithProvider(StaticContentProvider::class)->getFeed();

        $this->assertInternalType(
            'array',
            $feed
        );

        $this->assertGreaterThan(
            0,
            count($feed)
        );

        foreach ($feed as $post) {
            $this->assertInstanceOf(
                Post::class,
                $post
            );
        }
    }
}
