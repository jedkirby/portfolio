<?php

namespace App\Tests\Services\Instagram;

use App\Services\Instagram\Connections\Connection;
use App\Services\Instagram\Entity\Post;
use App\Services\Instagram\InstagramManager;
use App\Services\Instagram\InstagramService;
use App\Tests\AbstractTestCase;
use App\Tests\Services\Instagram\Connections\Providers\Fixtures\StaticContent as StaticContentProvider;

class InstagramManagerTest extends AbstractTestCase
{
    /**
     * @var array
     */
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

    /**
     * @return Post
     */
    private function getPost()
    {
        return InstagramManager::createFromArray($this->postDetails);
    }

    /**
     * @return InstagramService
     */
    private function getService()
    {
        return new InstagramService(
            new Connection(
                new StaticContentProvider()
            )
        );
    }

    /**
     * @test
     * @group instagram
     */
    public function itReturnsAnArrayOfIgnoredIds()
    {
        $this->assertInternalType(
            'array',
            InstagramManager::getIgnoredIds()
        );
    }

    /**
     * @test
     * @group instagram
     */
    public function itReturnAnInstanceOfTheCorrectClass()
    {
        $this->assertInstanceOf(
            Post::class,
            $this->getPost()
        );
    }

    /**
     * @test
     * @group instagram
     */
    public function itCanStoreAndGetPostsInMemory()
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

    /**
     * @test
     * @group instagram
     */
    public function itHasTheCorrectId()
    {
        $this->assertEquals(
            $this->getPost()->getId(),
            $this->postDetails['id']
        );
    }

    /**
     * @test
     * @group instagram
     */
    public function itHasTheCorrectLink()
    {
        $this->assertEquals(
            $this->getPost()->getLink(),
            $this->postDetails['link']
        );
    }

    /**
     * @test
     * @group instagram
     */
    public function itHasTheCorrectImage()
    {
        $this->assertEquals(
            $this->getPost()->getImage(),
            $this->postDetails['images']['low_resolution']['url']
        );
    }

    /**
     * @test
     * @group instagram
     */
    public function itHasTheCorrectText()
    {
        $this->assertEquals(
            $this->getPost()->getText(),
            $this->postDetails['caption']['text']
        );
    }

    /**
     * @test
     * @group instagram
     */
    public function itCorrectlyReturnsDefaultTextWhenNoneIsProvided()
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

    /**
     * @test
     * @group instagram
     */
    public function itGetsTheAllowedPosts()
    {
        $service = $this->getService();
        $feed = $service->getConnection()->getFeed();

        $posts = InstagramManager::getAllowedPosts($feed);

        $this->assertEquals(
            $feed,
            $posts
        );
    }

    /**
     * @test
     * @group instagram
     */
    public function itLimitsTheAllowedPosts()
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

    /**
     * @test
     * @group instagram
     */
    public function itRemovesPostsThatShouldBeIgnored()
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
     * @test
     * @group instagram
     * @expectedException \App\Services\Instagram\Exceptions\UnableToGetInstagramFeedPostsException
     */
    public function itThrowsAnExceptionWhenThereAreNoPosts()
    {
        InstagramManager::getAllowedPosts([]);
    }
}
