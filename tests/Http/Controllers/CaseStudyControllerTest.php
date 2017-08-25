<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Study\Entity\Item;
use App\Domain\Study\Repository\StudyRepository;
use App\Http\Controllers\CaseStudyController;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.study
 */
class CaseStudyControllerTest extends AbstractControllerTestCase
{
    private $studyRepository;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->studyRepository = Mockery::mock(StudyRepository::class);
        $this->controller = new CaseStudyController(
            $this->domain,
            $this->studyRepository
        );
    }

    private function getSampleEntity()
    {
        return new Item(
            'study-title',
            'Study Title',
            Carbon::create(2001, 3, 10, 17, 16, 18),
            'Study Snippet.',
            'assets/tests/sample.png',
            [
                'One',
                'Two',
            ]
        );
    }

    public function testCanGetSingleStudy()
    {
        $entity = $this->getSampleEntity();

        $this->studyRepository
            ->shouldReceive('getById')
            ->with('study-title')
            ->andReturn($entity)
            ->once();

        $this->domain
            ->shouldReceive('setTitle')
            ->with('Study Title')
            ->once();

        $this->domain
            ->shouldReceive('setDescription')
            ->with('Study Snippet.')
            ->once();

        $this->domain
            ->shouldReceive('setKeywords')
            ->with('One, Two')
            ->once();

        $view = $this->controller->single('study-title');
        $data = $view->getData();

        $this->assertInstanceOf(Item::class, $data['study']);
    }
}
