<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Blog\Entity\Article;
use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Service\Twitter\Entity\Tweet;
use App\Domain\Service\Twitter\TweetManager;
use App\Domain\Study\Entity\Item;
use App\Domain\Study\Repository\StudyRepository;
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
    private $studyRepository;
    private $tweetManager;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->articleRepository = Mockery::mock(ArticleRepository::class);
        $this->studyRepository = Mockery::mock(StudyRepository::class);
        $this->tweetManager = Mockery::mock(TweetManager::class);
        $this->controller = new HomeController(
            $this->domain,
            $this->articleRepository,
            $this->studyRepository,
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
            ->with(2)
            ->andReturn([
                Mockery::mock(Article::class),
                Mockery::mock(Article::class),
            ])
            ->once();

        $this->studyRepository
            ->shouldReceive('getLimit')
            ->with(3)
            ->andReturn([
                Mockery::mock(Item::class),
                Mockery::mock(Item::class),
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
        $this->assertArrayHasKey('studies', $data);

        $this->assertInternalType('array', $data['articles']);
        $this->assertInternalType('array', $data['studies']);

        $this->assertCount(2, $data['articles']);
        $this->assertCount(2, $data['studies']);
    }
}
