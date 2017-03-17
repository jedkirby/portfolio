<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Blog\Entity\Article;
use App\Domain\Project\Entity\Post;
use App\Domain\Project\Repository\PostRepository;
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
    private $postRepository;
    private $articleRepository;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->postRepository = Mockery::mock(
            PostRepository::class,
            [
                'getAll' => [
                    Mockery::mock(Post::class),
                    Mockery::mock(Post::class),
                ],
            ]
        );

        $this->articleRepository = Mockery::mock(
            ArticleRepository::class,
            [
                'getAll' => [
                    Mockery::mock(Article::class),
                    Mockery::mock(Article::class),
                ],
            ]
        );

        $this->controller = new SitemapController(
            $this->postRepository,
            $this->articleRepository
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
