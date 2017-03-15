<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Blog\BlogManager;
use App\Domain\Blog\Entity\Article;
use App\Domain\Domain;
use App\Domain\Project\Entity\Post;
use App\Domain\Project\ProjectManager;
use App\Domain\Service\Twitter\Entity\Tweet;
use App\Domain\Service\Twitter\TweetManager;
use App\Http\Controllers\HomeController;
use Mockery;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.home
 */
class HomeControllerTest extends AbstractControllerTestCase
{
    private $blog;
    private $project;
    private $twitter;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->blog = Mockery::mock(BlogManager::class);
        $this->project = Mockery::mock(ProjectManager::class);
        $this->twitter = Mockery::mock(TweetManager::class);
        $this->controller = new HomeController(
            $this->domain,
            $this->blog,
            $this->project,
            $this->twitter
        );
    }

    public function testGetContainsCorrectParams()
    {
        $this->domain
            ->shouldReceive('setDescription')
            ->once();

        $this->blog
            ->shouldReceive('getLimit')
            ->andReturn([
                Mockery::mock(Article::class),
                Mockery::mock(Article::class),
            ])
            ->once();

        $this->project
            ->shouldReceive('getLimit')
            ->andReturn([
                Mockery::mock(Post::class),
                Mockery::mock(Post::class),
            ])
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

        $this->assertCount(2, $data['articles']);
        $this->assertCount(2, $data['projects']);
    }
}
