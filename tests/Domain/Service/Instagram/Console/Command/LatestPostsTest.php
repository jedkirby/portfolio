<?php

namespace App\Tests\Domain\Service\Instagram\Console\Command;

use App\Domain\Service\Instagram\Connection\Connection;
use App\Domain\Service\Instagram\Console\Command\LatestPosts;
use App\Domain\Service\Instagram\Entity\Post;
use App\Domain\Service\Instagram\InstagramManager;
use App\Domain\Service\Instagram\InstagramService;
use App\Tests\AbstractAppTestCase as TestCase;
use App\Tests\Domain\Service\Instagram\Connection\Provider\Fixtures\StaticContent as StaticContentProvider;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.instagram
 * @group domain.service.instagram.console
 * @group domain.service.instagram.console.command
 */
class LatestPostsTest extends TestCase
{
    public function testItRunsTheCommandCorrectly()
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
