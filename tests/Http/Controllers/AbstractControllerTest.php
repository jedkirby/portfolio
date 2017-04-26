<?php

namespace App\Tests\Http\Controllers;

use App\Tests\Http\Controllers\Fixtures\SampleController;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.abstract
 */
class AbstractControllerTest extends AbstractControllerTestCase
{
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->controller = new SampleController(
            $this->domain
        );
    }

    public function testGettingDefaultViewParams()
    {
        $params = $this->controller->getDefaultViewParams();

        $this->assertEquals($params['title'], 'My Title');
        $this->assertEquals($params['description'], 'My Description');
        $this->assertEquals($params['keywords'], 'One, Two, Three');
        $this->assertEquals($params['author'], 'Author Bloggs');
    }

    public function testMergesViewParamsWithDefault()
    {
        $params = $this->controller->getViewParams([
            'custom' => 'Hello, World!',
        ]);

        $this->assertEquals($params['custom'], 'Hello, World!');
    }

    public function testViewParamsAreMoreImportant()
    {
        $params = $this->controller->getViewParams([
            'title' => 'My Important Title',
        ]);

        $this->assertEquals($params['title'], 'My Important Title');
    }
}
