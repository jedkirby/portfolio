<?php

namespace App\Tests\Integrtions;

// use App\Integrations\Instagram;
// use App\Integrations\Instagram\Post;
use App\Tests\AbstractTestCase;

class InstagramTest extends AbstractTestCase
{
    /**
     * Default post details.
     *
     * @var array
     */
    /*private $postDetails = [
        'id' => 'BJGINgWDSjR',
        'link' => 'https://www.instagram.com/p/BJGINgWDSjR/',
        'images' => [
            'low_resolution' => [
                'url' => 'https://scontent.cdninstagram.com/t51.2885-15/s320x320/e35/14026723_591240597730224_1149797403_n.jpg?ig_cache_key=MTMxNjc3NjA1MzUwNzQzNDcwNQ%3D%3D.2',
            ],
        ],
        'caption' => [
            'text' => 'This is the caption text!',
        ],
    ];*/

    /**
     * Return a post instance with the default details.
     *
     * @return Post
     */
    /*private function getPost()
    {
        return Instagram::createPostFromArray($this->postDetails);
    }*/

    /**
     * @test
     */
    /*public function itReturnAnInstanceOfTheCorrectClass()
    {
        return $this->assertInstanceOf(
            Post::class,
            $this->getPost()
        );
    }*/

    /**
     * @test
     */
    /*public function itHasTheCorrectId()
    {
        return $this->assertEquals(
            $this->getPost()->getId(),
            $this->postDetails['id']
        );
    }*/

    /**
     * @test
     */
    /*public function itHasTheCorrectLink()
    {
        return $this->assertEquals(
            $this->getPost()->getLink(),
            $this->postDetails['link']
        );
    }*/

    /**
     * @test
     */
    /*public function itHasTheCorrectImage()
    {
        return $this->assertEquals(
            $this->getPost()->getImage(),
            $this->postDetails['images']['low_resolution']['url']
        );
    }*/

    /**
     * @test
     */
    /*public function itHasTheCorrectText()
    {
        return $this->assertEquals(
            $this->getPost()->getText(),
            $this->postDetails['caption']['text']
        );
    }*/

    /**
     * @test
     */
    /*public function itUsesTheDefaultText()
    {
        $postExpectedDefaultText = 'This is the default text!';
        $post = Instagram::createPostFromArray([
            'id' => 'ABC123CDE',
            'link' => 'http://url.com',
            'images' => [
                'low_resolution' => [
                    'url' => 'http://url.com/image/1',
                ],
            ],
        ]);

        return $this->assertEquals(
            $post->getText($postExpectedDefaultText),
            $postExpectedDefaultText
        );
    }*/
}
