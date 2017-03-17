<?php

namespace App\Tests\Domain\Project;

use App\Domain\Project\Entity\Post;
use App\Domain\Project\Repository\PostRepository;
use App\Tests\AbstractAppTestCase as TestCase;
use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository as Config;
use Mockery;

/**
 * @group domain
 * @group domain.project
 * @group domain.project.repository
 * @group domain.project.repository.post
 */
class PostRepositoryTest extends TestCase
{
    private $postRepository;

    public function setUp()
    {
        $config = Mockery::mock(Config::class);
        $config
            ->shouldReceive('get')
            ->with('project.posts', [])
            ->andReturn([
                'project-title' => [
                    'title' => 'Project Title',
                    'subtitle' => 'Secondary Title',
                    'icon' => 'fa fa-home',
                    'date' => Carbon::createFromDate(2017, 3, 15),
                    'introduction' => 'This is the introduction.',
                    'content' => 'This is the content.',
                    'testimonial' => false,
                    'link' => 'http://test.com',
                    'expired' => false,
                    'hero' => '/img/hero.png',
                    'keywords' => [
                        'First',
                        'Second',
                    ],
                    'images' => [
                        '/img/first.png',
                        '/img/second.png',
                    ],
                ],
                'another-project-title' => [
                    'title' => 'Another Project Title',
                    'subtitle' => 'Third Title',
                    'icon' => 'fa fa-home',
                    'date' => Carbon::createFromDate(2015, 2, 19),
                    'introduction' => 'This is the introduction.',
                    'content' => 'This is the content.',
                    'testimonial' => false,
                    'link' => 'http://test.com',
                    'expired' => false,
                    'hero' => '/img/hero-two.png',
                    'keywords' => [
                        'Third',
                        'Fourth',
                    ],
                    'images' => [
                        '/img/third.png',
                        '/img/fourth.png',
                    ],
                ],
            ])
            ->once();

        $this->postRepository = new PostRepository($config);
    }

    public function testConvertPostsToEntities()
    {
        $posts = $this->postRepository->getAll();
        foreach ($posts as $id => $post) {
            $this->assertInstanceOf(Post::class, $post);
        }
    }

    public function testCountIsCorrect()
    {
        $this->assertEquals(
            2,
            $this->postRepository->getCount()
        );
    }

    public function testCanLimitPostsReturned()
    {
        $limit = 1;
        $this->assertCount(
            $limit,
            $this->postRepository->getLimit($limit)
        );
    }

    /**
     * @expectedException \App\Domain\Common\Exception\EntityNotFoundException
     */
    public function testThrowsExceptionWhenNotFound()
    {
        $post = $this->postRepository->getById('does-not-exist');
    }

    public function testCanGetById()
    {
        $this->assertInstanceOf(
            Post::class,
            $this->postRepository->getById('project-title')
        );
    }
}
