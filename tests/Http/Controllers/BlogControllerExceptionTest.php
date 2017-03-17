<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Domain;
use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Social\Page;
use App\Http\Controllers\BlogController;
use App\Tests\AbstractAppTestCase as TestCase;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.blog
 */
class BlogControllerExceptionTest extends TestCase
{
    private $domain;
    private $articleRepository;
    private $page;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->domain = Mockery::mock(Domain::class);
        $this->articleRepository = Mockery::mock(ArticleRepository::class);
        $this->page = Mockery::mock(Page::class);
        $this->controller = new BlogController(
            $this->domain,
            $this->articleRepository,
            $this->page
        );
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testThrowsExceptionWhenNotFound()
    {
        $this->articleRepository
            ->shouldReceive('getById')
            ->with('my-project')
            ->andThrow(EntityNotFoundException::class)
            ->once();

        $this->controller->single('my-project');
    }
}
