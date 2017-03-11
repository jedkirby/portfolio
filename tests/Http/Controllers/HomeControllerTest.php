<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Service\Twitter\Entity\Tweet;
use App\Domain\Service\Twitter\TweetManager as Twitter;
use App\Http\Controllers\HomeController;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.home
 */
class HomeControllerTest extends ControllerTestCase
{
    private $twitter;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->twitter = Mockery::mock(Twitter::class);
        $this->controller = new HomeController(
            $this->domain,
            $this->twitter
        );
    }

    public function testGetContainsCorrectParams()
    {
        $this->domain
            ->shouldReceive('setDescription')
            ->once();

        $this->twitter
            ->shouldReceive('getTweet')
            ->andReturn(Mockery::mock(Tweet::class))
            ->once();

        $view = $this->controller->__invoke();
        $data = $view->getData();

        $this->assertInstanceOf(Tweet::class, $data['tweet']);
        $this->assertArrayHasKey('articles', $data);
        $this->assertArrayHasKey('projects', $data);
        $this->assertInternalType('array', $data['articles']);
        $this->assertInternalType('array', $data['projects']);
    }
}
