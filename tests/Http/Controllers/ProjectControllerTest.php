<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Social\Page;
use App\Domain\Domain;
use App\Domain\Project\Entity\Post;
use App\Domain\Project\Repository\PostRepository;
use App\Http\Controllers\ProjectController;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.project
 */
class ProjectControllerTest extends AbstractControllerTestCase
{
    private $postRepository;
    private $page;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->postRepository = Mockery::mock(PostRepository::class);
        $this->page = Mockery::mock(Page::class);
        $this->controller = new ProjectController(
            $this->domain,
            $this->postRepository,
            $this->page
        );
    }

    private function getSamplePosts()
    {
        return [
            Mockery::mock(
                Post::class,
                [
                    'getTitle' => 'Post One',
                    'getSubtitle' => 'Something',
                ]
            ),
            Mockery::mock(
                Post::class,
                [
                    'getTitle' => 'Post Two',
                    'getSubtitle' => 'Else',
                ]
            ),
        ];
    }

    private function getSamplePost()
    {
        return Mockery::mock(
            Post::class,
            [
                'getId' => 'project-one',
                'getTitle' => 'Project One',
                'getSubtitle' => 'Project Sub Title',
                'getIcon' => 'fa fa-icon',
                'getDate' => '2014-06-09',
                'getIntroduction' => '<p>This is the introduction.</p>',
                'getIntroductionForMeta' => 'This is the introduction.',
                'getContent' => '<p>This is the content.</p>',
                'getTestimonial' => false,
                'getLink' => 'http://test.com',
                'getExpired' => false,
                'getHero' => 'http://test.com/img/hero.png',
                'getKeywords' => [
                    'One',
                    'Two'
                ],
                'getImages' => [
                    'http://test.com/img/one.png',
                    'http://test.com/img/two.png',
                ],
                'getUrl' => 'http://test.com/work/project-one',
            ]
        );
    }

    public function testGetAll()
    {
        $this->postRepository
            ->shouldReceive('getAll')
            ->andReturn($this->getSamplePosts())
            ->once();

        $this->domain
            ->shouldReceive('setTitle')
            ->with('Work')
            ->once();

        $this->domain
            ->shouldReceive('setDescription')
            ->once();

        $this->domain
            ->shouldReceive('setKeywords')
            ->once();

        $view = $this->controller->all();
        $data = $view->getData();

        $this->assertArrayHasKey('projects', $data);
        $this->assertInternalType('array', $data['projects']);
        $this->assertCount(2, $data['projects']);
    }

    public function testGetAllCompilesKeywords()
    {
        $posts = $this->getSamplePosts();

        $this->postRepository
            ->shouldReceive('getAll')
            ->andReturn($posts)
            ->once();

        $this->domain
            ->shouldReceive('setTitle')
            ->with('Work')
            ->once();

        $this->domain
            ->shouldReceive('setDescription')
            ->once();

        $keywords = [];
        foreach ($posts as $post) {
            $keywords[] = $post->getTitle();
            $keywords[] = $post->getSubTitle();
        }

        $this->domain
            ->shouldReceive('setKeywords')
            ->with($keywords)
            ->once();

        $this->controller->all();
    }

    public function testCanGetSinglePost()
    {
        $post = $this->getSamplePost();

        $this->postRepository
            ->shouldReceive('getById')
            ->with('project-one')
            ->andReturn($post)
            ->once();

        $this->domain
            ->shouldReceive('setTitle')
            ->with('Project One')
            ->once();

        $this->domain
            ->shouldReceive('setDescription')
            ->with('This is the introduction.')
            ->once();

        $this->domain
            ->shouldReceive('setKeywords')
            ->with([
                    'One',
                    'Two'
            ])
            ->once();

        $this->page
            ->shouldReceive('setUrl')
            ->with('http://test.com/work/project-one')
            ->once();

        $this->page
            ->shouldReceive('setTitle')
            ->with('Project One')
            ->once();

        $this->page
            ->shouldReceive('setText')
            ->with('This is the introduction.')
            ->once();

        $this->page
            ->shouldReceive('setImage')
            ->with('http://test.com/img/one.png')
            ->once();

        $view = $this->controller->single('project-one');
        $data = $view->getData();

        $this->assertInstanceOf(Post::class, $data['project']);
        $this->assertInstanceOf(Page::class, $data['page']);
    }
}
