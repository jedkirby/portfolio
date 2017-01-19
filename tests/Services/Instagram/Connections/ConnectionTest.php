<?php

namespace App\Tests\Services\Instagram\Connections;

use App\Services\Instagram\Connections\Connection;
use App\Services\Instagram\Connections\ConnectionInterface;
use App\Services\Instagram\Entity\Post;
use App\Tests\AbstractTestCase;
use App\Tests\Services\Instagram\Connections\Providers\Fixtures\EmptyContent as EmptyContentProvider;
use App\Tests\Services\Instagram\Connections\Providers\Fixtures\StaticContent as StaticContentProvider;

class ConnectionTest extends AbstractTestCase
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
     * @group instagram
     */
    public function itReturnsAnEmptyArrayForNoFeed()
    {
        $feed = $this->getConnectionWithProvider(EmptyContentProvider::class)->getFeed();

        $this->assertInternalType(
            'array',
            $feed
        );

        $this->assertEmpty($feed);
    }

    /**
     * @test
     * @group instagram
     */
    public function itReturnsPostsForFeed()
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
