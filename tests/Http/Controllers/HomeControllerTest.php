<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Project\Entity\PostInterface;
use App\Domain\Project\ProjectManager as Projects;
use App\Domain\Service\Twitter\Entity\Tweet;
use App\Domain\Service\Twitter\TweetManager as Twitter;
use App\Http\Controllers\HomeController;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.home
 */
class HomeControllerTest extends AbstractControllerTestCase
{
    private $twitter;
    private $projects;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->twitter = Mockery::mock(Twitter::class);
        $this->projects = Mockery::mock(Projects::class);
        $this->controller = new HomeController(
            $this->domain,
            $this->twitter,
            $this->projects
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

        $this->projects
            ->shouldReceive('getPosts')
            ->andReturn([
                Mockery::mock(PostInterface::class),
                Mockery::mock(PostInterface::class),
            ])
            ->once();

        $view = $this->controller->__invoke();
        $data = $view->getData();

        $this->assertInstanceOf(Tweet::class, $data['tweet']);

        $this->assertArrayHasKey('articles', $data);
        $this->assertArrayHasKey('posts', $data);

        $this->assertInternalType('array', $data['articles']);
        $this->assertInternalType('array', $data['posts']);

        $this->assertCount(0, $data['articles']);
        $this->assertCount(2, $data['posts']);
    }
}
