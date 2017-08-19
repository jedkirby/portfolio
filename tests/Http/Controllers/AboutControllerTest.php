<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Service\Instagram\Entity\Post;
use App\Domain\Service\Instagram\InstagramManager;
use App\Domain\Work\Repository\WorkRepository;
use App\Http\Controllers\AboutController;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.about
 */
class AboutControllerTest extends AbstractControllerTestCase
{
    private $articleRepository;
    private $workRepository;
    private $instagramManager;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->articleRepository = Mockery::mock(ArticleRepository::class);
        $this->workRepository = Mockery::mock(WorkRepository::class);
        $this->instagramManager = Mockery::mock(InstagramManager::class);
        $this->controller = new AboutController(
            $this->domain,
            $this->articleRepository,
            $this->workRepository,
            $this->instagramManager
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

        $this->articleRepository
            ->shouldReceive('getCount')
            ->andReturn(3)
            ->once();

        $this->workRepository
            ->shouldReceive('getCount')
            ->andReturn(3)
            ->once();

        $this->instagramManager
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
        $this->assertArrayHasKey('work', $data['counts']);
        $this->assertArrayHasKey('articles', $data['counts']);

        $this->assertInternalType('array', $data['instagram']);
        $this->assertInternalType('int', $data['counts']['tea']);
        $this->assertInternalType('int', $data['counts']['food']);
        $this->assertInternalType('int', $data['counts']['work']);
        $this->assertInternalType('int', $data['counts']['articles']);

        $this->assertEquals($data['counts']['work'], (3 + 12));
        $this->assertEquals($data['counts']['articles'], 3);
    }
}
