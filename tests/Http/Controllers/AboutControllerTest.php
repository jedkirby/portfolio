<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Service\Instagram\Entity\Post;
use App\Domain\Service\Instagram\InstagramManager as Instagram;
use App\Http\Controllers\AboutController;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.about
 */
class AboutControllerTest extends ControllerTestCase
{
    private $instagram;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->instagram = Mockery::mock(Instagram::class);
        $this->controller = new AboutController(
            $this->domain,
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
    }
}
