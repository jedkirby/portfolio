<?php

namespace App\Tests\Services\Instagram\Commands;

use App\Services\Instagram\Commands\LatestPosts;
use App\Services\Instagram\Connections\Connection;
use App\Services\Instagram\Entity\Post;
use App\Services\Instagram\InstagramManager;
use App\Services\Instagram\InstagramService;
use App\Tests\AbstractTestCase;
use App\Tests\Services\Instagram\Connections\Providers\Fixtures\StaticContent as StaticContentProvider;

class LatestPostsTest extends AbstractTestCase
{
    /**
     * @test
     * @group instagram
     */
    public function itRunsTheCommandCorrectly()
    {
        $manager = new InstagramManager();
        $service = new InstagramService(
            new Connection(
                new StaticContentProvider()
            )
        );

        $manager::clearCache();

        $this->assertFalse(
            $manager::getPosts()
        );

        (new LatestPosts($service, $manager))->handle();

        $posts = $manager::getPosts();

        $this->assertInternalType(
            'array',
            $posts
        );

        $this->assertGreaterThan(
            0,
            count($posts)
        );

        foreach ($posts as $post) {
            $this->assertInstanceOf(
                Post::class,
                $post
            );
        }

        $manager::clearCache();
    }
}
