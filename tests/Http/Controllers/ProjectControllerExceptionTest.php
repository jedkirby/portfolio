<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Domain;
use App\Domain\Project\ProjectManager;
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
    private $project;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->domain = Mockery::mock(Domain::class);
        $this->project = Mockery::mock(ProjectManager::class);
        $this->controller = new ProjectController(
            $this->domain,
            $this->project
        );
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testThrowsExceptionWhenNotFound()
    {
        $this->project
            ->shouldReceive('getById')
            ->with('my-project')
            ->andThrow(EntityNotFoundException::class)
            ->once();

        $this->controller->single('my-project');
    }
}
