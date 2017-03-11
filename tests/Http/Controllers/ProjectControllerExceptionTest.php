<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Project\Exception\PostNotFoundException;
use App\Domain\Project\ProjectManager as Projects;
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
    private $projects;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->domain = Mockery::mock(Domain::class);
        $this->projects = Mockery::mock(Projects::class);
        $this->controller = new ProjectController(
            $this->domain,
            $this->projects
        );
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testThrowsExceptionWhenNotFound()
    {
        $this->projects
            ->shouldReceive('getPost')
            ->with('my-project')
            ->andThrow(PostNotFoundException::class)
            ->once();

        $this->controller->single('my-project');
    }
}
