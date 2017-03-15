<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Blog\BlogManager;
use App\Domain\Project\ProjectManager;
use App\Domain\Service\Instagram\Entity\Post;
use App\Domain\Service\Instagram\InstagramManager;
use App\Http\Controllers\AboutController;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.about
 */
class AboutControllerTest extends AbstractControllerTestCase
{
    private $blog;
    private $project;
    private $instagram;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->blog = Mockery::mock(BlogManager::class);
        $this->project = Mockery::mock(ProjectManager::class);
        $this->instagram = Mockery::mock(InstagramManager::class);
        $this->controller = new AboutController(
            $this->domain,
            $this->blog,
            $this->project,
            $this->instagram
        );
    }

    public function testGetContainsCorrectParams()
    {
        $this->domain
            ->shouldReceive('setTitle')
            ->with('About')
            ->once();

        $this->domain
            ->shouldReceive('setDescription')
            ->once();

        $this->blog
            ->shouldReceive('getCount')
            ->andReturn(3)
            ->once();

        $this->project
            ->shouldReceive('getCount')
            ->andReturn(3)
            ->once();

        $this->instagram
            ->shouldReceive('getPosts')
            ->andReturn([
                Mockery::mock(Post::class),
                Mockery::mock(Post::class),
            ])
            ->once();

        $view = $this->controller->__invoke();
        $data = $view->getData();

        $this->assertArrayHasKey('instagram', $data);
        $this->assertArrayHasKey('counts', $data);
        $this->assertArrayHasKey('tea', $data['counts']);
        $this->assertArrayHasKey('food', $data['counts']);
        $this->assertArrayHasKey('projects', $data['counts']);
        $this->assertArrayHasKey('articles', $data['counts']);

        $this->assertInternalType('array', $data['instagram']);
        $this->assertInternalType('int', $data['counts']['tea']);
        $this->assertInternalType('int', $data['counts']['food']);
        $this->assertInternalType('int', $data['counts']['projects']);
        $this->assertInternalType('int', $data['counts']['articles']);

        $this->assertEquals($data['counts']['projects'], 3);
        $this->assertEquals($data['counts']['articles'], 3);
    }
}
