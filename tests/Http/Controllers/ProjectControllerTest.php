<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Project\Entity\PostInterface;
use App\Domain\Project\ProjectManager as Projects;
use App\Http\Controllers\ProjectController;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.project
 */
class ProjectControllerTest extends AbstractControllerTestCase
{
    private $projects;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->projects = Mockery::mock(Projects::class);
        $this->controller = new ProjectController(
            $this->domain,
            $this->projects
        );
    }

    private function getSamplePosts()
    {
        return [
            Mockery::mock(
                PostInterface::class,
                [
                    'getTitle' => 'Post One',
                    'getSubTitle' => 'Something',
                ]
            ),
            Mockery::mock(
                PostInterface::class,
                [
                    'getTitle' => 'Post Two',
                    'getSubTitle' => 'Else',
                ]
            ),
        ];
    }

    public function testGetAll()
    {
        $this->projects
            ->shouldReceive('getPosts')
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

        $this->assertArrayHasKey('posts', $data);
        $this->assertInternalType('array', $data['posts']);
        $this->assertCount(2, $data['posts']);
    }

    public function testGetAllCompilesKeywords()
    {
        $posts = $this->getSamplePosts();

        $this->projects
            ->shouldReceive('getPosts')
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

    public function testOnlyUniqueKeywordsAreUsed()
    {
        $this->markTestIncomplete();
    }

    public function testKeywordsAreLimited()
    {
        $this->markTestIncomplete();
    }

    public function testCanGetSinglePost()
    {
        $this->markTestIncomplete();
    }
}
