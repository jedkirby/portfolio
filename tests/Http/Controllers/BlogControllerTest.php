<?php

namespace App\Tests\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Blog\Entity\Article;
use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Social\Page;
use App\Http\Controllers\BlogController;
use Mockery;
use Carbon\Carbon;

/**
 * @group http
 * @group http.controllers
 * @group http.controllers.blog
 */
class BlogControllerTest extends AbstractControllerTestCase
{
    private $articleRepository;
    private $page;
    private $controller;

    public function setUp()
    {
        parent::setUp();

        $this->articleRepository = Mockery::mock(ArticleRepository::class);
        $this->page = Mockery::mock(Page::class);
        $this->controller = new BlogController(
            $this->domain,
            $this->articleRepository,
            $this->page
        );
    }

    private function getSampleEntities()
    {
        return [
            Mockery::mock(
                Article::class,
                [
                    'getKeywords' => ['One', 'Two']
                ]
            ),
            Mockery::mock(
                Article::class,
                [
                    'getKeywords' => ['Three', 'Four'],
                ]
            ),
        ];
    }

    private function getSampleEntity()
    {
        return new Article(
            'post-title',
            'Post Title',
            Carbon::create(2001, 3, 10, 17, 16, 18),
            'Post Snippet.',
            'tests.sample',
            'assets/tests/sample.png',
            [
                'One',
                'Two',
            ]
        );
    }

    public function testGetAll()
    {
        $this->articleRepository
            ->shouldReceive('getAll')
            ->andReturn($this->getSampleEntities())
            ->once();

        $this->domain
            ->shouldReceive('setTitle')
            ->with('Blog')
            ->once();

        $this->domain
            ->shouldReceive('setDescription')
            ->once();

        $this->domain
            ->shouldReceive('setKeywords')
            ->once();

        $view = $this->controller->all();
        $data = $view->getData();

        $this->assertArrayHasKey('articles', $data);
        $this->assertInternalType('array', $data['articles']);
        $this->assertCount(2, $data['articles']);
    }

    public function testGetAllCompilesKeywords()
    {
        $entities = $this->getSampleEntities();

        $this->articleRepository
            ->shouldReceive('getAll')
            ->andReturn($entities)
            ->once();

        $this->domain
            ->shouldReceive('setTitle')
            ->with('Blog')
            ->once();

        $this->domain
            ->shouldReceive('setDescription')
            ->once();

        $keywords = [];
        foreach ($entities as $entity) {
            $keywords = array_merge($keywords, $entity->getKeywords());
        }

        $this->domain
            ->shouldReceive('setKeywords')
            ->with($keywords)
            ->once();

        $this->controller->all();
    }

    public function testKeywordsAreLimitedAndUnique()
    {
        $entities = [
            Mockery::mock(Article::class, ['getKeywords' => ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven']]),
            Mockery::mock(Article::class, ['getKeywords' => ['Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen']]),
            Mockery::mock(Article::class, ['getKeywords' => ['Fifteen', 'Sixteen', 'Seventeen', 'One']]),
        ];

        $this->articleRepository
            ->shouldReceive('getAll')
            ->andReturn($entities)
            ->once();

        $this->domain->shouldReceive('setTitle')->once();
        $this->domain->shouldReceive('setDescription')->once();

        $keywords = [];
        foreach ($entities as $entity) {
            $keywords = array_merge($keywords, $entity->getKeywords());
        }

        $expected = array_unique(
            array_slice($keywords, 0, BlogController::KEYWORD_LIMIT)
        );

        $this->domain
            ->shouldReceive('setKeywords')
            ->with($expected)
            ->once();

        $this->controller->all();
    }

    public function testCanGetSinglePost()
    {
        $entity = $this->getSampleEntity();

        $this->articleRepository
            ->shouldReceive('getById')
            ->with('post-title')
            ->andReturn($entity)
            ->once();

        $this->domain
            ->shouldReceive('setTitle')
            ->with('Post Title')
            ->once();

        $this->domain
            ->shouldReceive('setDescription')
            ->with('Post Snippet.')
            ->once();

        $this->domain
            ->shouldReceive('setKeywords')
            ->with([
                    'One',
                    'Two',
            ])
            ->once();

        $this->page
            ->shouldReceive('setUrl')
            ->with('http://localhost/blog/post-title')
            ->once();

        $this->page
            ->shouldReceive('setTitle')
            ->with('Post Title')
            ->once();

        $this->page
            ->shouldReceive('setText')
            ->with('Post Snippet.')
            ->once();

        $this->page
            ->shouldReceive('setImage')
            ->once();

        $view = $this->controller->single('post-title');
        $data = $view->getData();

        $this->assertInstanceOf(Article::class, $data['article']);
        $this->assertInstanceOf(Page::class, $data['page']);
    }
}
