<?php

namespace App\Tests\Domain\Service\Instagram;

use App\Domain\Service\Instagram\Connection\Connection;
use App\Domain\Service\Instagram\Entity\Post;
use App\Domain\Service\Instagram\InstagramManager;
use App\Domain\Service\Instagram\InstagramService;
use App\Tests\AbstractAppTestCase as TestCase;
use App\Tests\Domain\Service\Instagram\Connection\Provider\Fixtures\StaticContent as StaticContentProvider;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.instagram
 * @group domain.service.instagram.manager
 */
class InstagramManagerTest extends TestCase
{
    private $postDetails = [
        'id' => '22721881',
        'link' => 'http://instagr.am/p/BWrVZ/',
        'images' => [
            'low_resolution' => [
                'url' => 'http://distillery.s3.amazonaws.com/media/2011/02/02/6ea7baea55774c5e81e7e3e1f6e791a7_6.jpg',
            ],
        ],
        'caption' => [
            'text' => 'Inside le truc #foodtruck',
        ],
    ];

    private function getPost()
    {
        return InstagramManager::createFromArray($this->postDetails);
    }

    private function getService()
    {
        return new InstagramService(
            new Connection(
                new StaticContentProvider()
            )
        );
    }

    public function testItReturnsAnArrayOfIgnoredIds()
    {
        $this->assertInternalType(
            'array',
            InstagramManager::getIgnoredIds()
        );
    }

    public function testItReturnAnInstanceOfTheCorrectClass()
    {
        $this->assertInstanceOf(
            Post::class,
            $this->getPost()
        );
    }

    public function testItCanStoreAndGetPostsInMemory()
    {
        InstagramManager::clearCache();

        $post = $this->getPost();

        InstagramManager::setPosts([$post]);

        $storedPosts = InstagramManager::getPosts();

        $this->assertInternalType(
            'array',
            $storedPosts
        );

        $storedPost = reset($storedPosts);

        $this->assertInstanceOf(
            Post::class,
            $storedPost
        );

        $this->assertEquals(
            $post->getId(),
            $storedPost->getId()
        );

        InstagramManager::clearCache();
    }

    public function testItHasTheCorrectId()
    {
        $this->assertEquals(
            $this->getPost()->getId(),
            $this->postDetails['id']
        );
    }

    public function testItHasTheCorrectLink()
    {
        $this->assertEquals(
            $this->getPost()->getLink(),
            $this->postDetails['link']
        );
    }

    public function testItHasTheCorrectImage()
    {
        $this->assertEquals(
            $this->getPost()->getImage(),
            $this->postDetails['images']['low_resolution']['url']
        );
    }

    public function testItHasTheCorrectText()
    {
        $this->assertEquals(
            $this->getPost()->getText(),
            $this->postDetails['caption']['text']
        );
    }

    public function testItCorrectlyReturnsDefaultTextWhenNoneIsProvided()
    {
        $postDefaultText = 'This is the default.';

        $postDetails = $this->postDetails;
        $postDetails['caption']['text'] = '';

        $post = InstagramManager::createFromArray($postDetails);

        $this->assertFalse(
            $post->hasText()
        );

        $this->assertEquals(
            $post->getText($postDefaultText),
            $postDefaultText
        );
    }

    public function testItGetsTheAllowedPosts()
    {
        $service = $this->getService();
        $feed = $service->getConnection()->getFeed();

        $posts = InstagramManager::getAllowedPosts($feed);

        $this->assertEquals(
            $feed,
            $posts
        );
    }

    public function testItLimitsTheAllowedPosts()
    {
        $limit = 1;
        $service = $this->getService();
        $feed = $service->getConnection()->getFeed();

        $posts = InstagramManager::getAllowedPosts($feed, $limit);

        $this->assertCount(
            $limit,
            $posts
        );
    }

    public function testItRemovesPostsThatShouldBeIgnored()
    {
        $ignoredId = '22721881';
        $service = $this->getService();
        $feed = $service->getConnection()->getFeed();

        $posts = InstagramManager::getAllowedPosts($feed, false, [$ignoredId]);

        $found = false;
        foreach ($posts as $post) {
            if ($post->getId() === $ignoredId) {
                $found = true;
            }
        }

        $this->assertFalse(
            $found,
            'A post that should have been ignored, has not been.'
        );
    }

    /**
     * @expectedException \App\Domain\Service\Instagram\Exception\UnableToGetInstagramFeedPostsException
     */
    public function testItThrowsAnExceptionWhenThereAreNoPosts()
    {
        InstagramManager::getAllowedPosts([]);
    }
}
