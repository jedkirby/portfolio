<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Social\Page;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Domain;
use App\Domain\Project\Repository\PostRepository;
use App\Http\Controllers\ProjectController;
use App\Tests\AbstractAppTestCase as TestCase;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.project
 */
class ProjectControllerExceptionTest extends TestCase
{
    private $domain;
    private $postRepository;
    private $page;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->domain = Mockery::mock(Domain::class);
        $this->postRepository = Mockery::mock(PostRepository::class);
        $this->page = Mockery::mock(Page::class);
        $this->controller = new ProjectController(
            $this->domain,
            $this->postRepository,
            $this->page
        );
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testThrowsExceptionWhenNotFound()
    {
        $this->postRepository
            ->shouldReceive('getById')
            ->with('my-project')
            ->andThrow(EntityNotFoundException::class)
            ->once();

        $this->controller->single('my-project');
    }
}
