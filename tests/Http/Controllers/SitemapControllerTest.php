<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Blog\BlogManager;
use App\Domain\Blog\Entity\Article;
use App\Domain\Project\Entity\Post;
use App\Domain\Project\ProjectManager;
use App\Http\Controllers\SitemapController;
use App\Tests\AbstractAppTestCase as TestCase;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.sitemap
 */
class SitemapControllerTest extends TestCase
{
    private $project;
    private $blog;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->project = Mockery::mock(
            ProjectManager::class,
            [
                'getAll' => [
                    Mockery::mock(Post::class),
                    Mockery::mock(Post::class),
                ],
            ]
        );

        $this->blog = Mockery::mock(
            BlogManager::class,
            [
                'getAll' => [
                    Mockery::mock(Article::class),
                    Mockery::mock(Article::class),
                ],
            ]
        );

        $this->controller = new SitemapController(
            $this->project,
            $this->blog
        );
    }

    public function testReturnsXml()
    {
        $response = $this->controller->__invoke();

        $this->assertEquals(
            $response->headers->get('Content-Type'),
            'text/xml'
        );
    }

    public function testReturnsRoutingArray()
    {
        $response = $this->controller->__invoke();

        $data = $response->getOriginalContent()->getData();

        $this->assertArrayHasKey('routes', $data);
        $this->assertInternalType('array', $data['routes']);
    }
}
