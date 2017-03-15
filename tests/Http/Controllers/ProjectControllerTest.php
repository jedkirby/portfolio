<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Project\Entity\Post;
use App\Domain\Project\ProjectManager;
use App\Http\Controllers\ProjectController;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.project
 */
class ProjectControllerTest extends AbstractControllerTestCase
{
    private $project;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->project = Mockery::mock(ProjectManager::class);
        $this->controller = new ProjectController(
            $this->domain,
            $this->project
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

    public function testGetAll()
    {
        $this->project
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

        $this->project
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
