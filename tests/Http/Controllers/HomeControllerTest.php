<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Blog\Entity\Article;
use App\Domain\Domain;
use App\Domain\Project\Entity\Post;
use App\Domain\Project\Repository\PostRepository;
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
    private $articleRepository;
    private $postRepository;
    private $tweetManager;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->articleRepository = Mockery::mock(ArticleRepository::class);
        $this->postRepository = Mockery::mock(PostRepository::class);
        $this->tweetManager = Mockery::mock(TweetManager::class);
        $this->controller = new HomeController(
            $this->domain,
            $this->articleRepository,
            $this->postRepository,
            $this->tweetManager
        );
    }

    public function testGetContainsCorrectParams()
    {
        $this->domain
            ->shouldReceive('setDescription')
            ->once();

        $this->articleRepository
            ->shouldReceive('getLimit')
            ->andReturn([
                Mockery::mock(Article::class),
                Mockery::mock(Article::class),
            ])
            ->once();

        $this->postRepository
            ->shouldReceive('getLimit')
            ->andReturn([
                Mockery::mock(Post::class),
                Mockery::mock(Post::class),
            ])
            ->once();

        $this->tweetManager
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
