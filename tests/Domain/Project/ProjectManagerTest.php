<?php

namespace App\Tests\Domain\Project;

use App\Domain\Project\Entity\Post;
use App\Domain\Project\ProjectManager;
use App\Tests\AbstractAppTestCase as TestCase;
use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository as Config;
use Mockery;

/**
 * @group domain
 * @group domain.project
 * @group domain.project.manager
 */
class ProjectManagerTest extends TestCase
{
    private $project;

    public function __construct()
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

        $this->project = new ProjectManager($config);
    }

    public function testConvertPostsToEntities()
    {
        $posts = $this->project->getAll();
        foreach ($posts as $post) {
            $this->assertInstanceOf(Post::class, $post);
        }
    }

    public function testCountIsCorrect()
    {
        $this->assertEquals(
            2,
            $this->project->getCount()
        );
    }

    public function testCanLimitPostsReturned()
    {
        $limit = 1;
        $this->assertCount(
            $limit,
            $this->project->getLimit($limit)
        );
    }

    /**
     * @expectedException \App\Domain\Common\Exception\EntityNotFoundException
     */
    public function testThrowsExceptionWhenNotFound()
    {
        $post = $this->project->getById('does-not-exist');
    }

    public function testCanGetById()
    {
        $this->assertInstanceOf(
            Post::class,
            $this->project->getById('project-title')
        );
    }
}
