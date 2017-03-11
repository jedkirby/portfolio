<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Project\Entity\PostInterface;
use App\Domain\Project\ProjectManager as Projects;
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
    private $projects;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->projects = Mockery::mock(
            Projects::class,
            [
                'getPosts' => [
                    Mockery::mock(PostInterface::class),
                    Mockery::mock(PostInterface::class),
                ],
            ]
        );

        $this->controller = new SitemapController(
            $this->projects
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
