<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Domain;
use App\Domain\Study\Repository\StudyRepository;
use App\Http\Controllers\CaseStudyController;
use App\Tests\AbstractAppTestCase as TestCase;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.study
 */
class CaseStudyControllerExceptionTest extends TestCase
{
    private $domain;
    private $studyRepository;
    private $page;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->domain = Mockery::mock(Domain::class);
        $this->studyRepository = Mockery::mock(StudyRepository::class);
        $this->controller = new CaseStudyController(
            $this->domain,
            $this->studyRepository
        );
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testThrowsExceptionWhenNotFound()
    {
        $this->studyRepository
            ->shouldReceive('getById')
            ->with('my-study')
            ->andThrow(EntityNotFoundException::class)
            ->once();

        $this->controller->single('my-study');
    }
}
