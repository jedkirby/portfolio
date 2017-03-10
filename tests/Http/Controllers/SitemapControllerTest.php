<?php

namespace App\Tests\Http\Controllers;

use App\Http\Controllers\SitemapController;
use App\Tests\AbstractAppTestCase as TestCase;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.sitemap
 */
class SitemapControllerTest extends TestCase
{
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->controller = new SitemapController();
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
