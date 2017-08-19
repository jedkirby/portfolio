<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Blog\Entity\Article;
use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Work\Entity\Item;
use App\Domain\Work\Repository\WorkRepository;
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
    private $workRepository;
    private $articleRepository;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->workRepository = Mockery::mock(
            WorkRepository::class,
            [
                'getAll' => [
                    Mockery::mock(Item::class),
                    Mockery::mock(Item::class),
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
            $this->workRepository,
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
