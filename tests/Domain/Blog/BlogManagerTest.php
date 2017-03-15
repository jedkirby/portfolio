<?php

namespace App\Tests\Domain\Blog;

use App\Domain\Blog\BlogManager;
use App\Domain\Blog\Entity\Article;
use App\Tests\AbstractAppTestCase as TestCase;
use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository as Config;
use Mockery;

/**
 * @group domain
 * @group domain.blog
 * @group domain.blog.manager
 */
class BlogManagerTest extends TestCase
{
    private $blog;

    public function setUp()
    {
        $config = Mockery::mock(Config::class);
        $config
            ->shouldReceive('get')
            ->with('blog.articles', [])
            ->andReturn([
                'post-title' => [
                    'title' => 'Post Title',
                    'date' => Carbon::createFromDate(2017, 3, 15),
                    'snippet' => 'This is the snippet.',
                    'content' => 'This is the content.',
                    'image' => 'http://test.com/image.png',
                    'keywords' => [
                        'First',
                        'Second',
                    ],
                ],
                'another-post-title' => [
                    'title' => 'Another Post Title',
                    'date' => Carbon::createFromDate(2015, 2, 11),
                    'snippet' => 'This is the snippet.',
                    'content' => 'This is the content.',
                    'image' => 'http://test.com/image-two.png',
                    'keywords' => [
                        'Third',
                        'Fourth',
                    ],
                ],
            ])
            ->once();

        $this->blog = new BlogManager($config);
    }

    public function testConvertArticlesToEntities()
    {
        $articles = $this->blog->getAll();
        foreach ($articles as $article) {
            $this->assertInstanceOf(Article::class, $article);
        }
    }

    public function testCountIsCorrect()
    {
        $this->assertEquals(
            2,
            $this->blog->getCount()
        );
    }

    public function testCanLimitArticlesReturned()
    {
        $limit = 1;
        $this->assertCount(
            $limit,
            $this->blog->getLimit($limit)
        );
    }

    /**
     * @expectedException \App\Domain\Common\Exception\EntityNotFoundException
     */
    public function testThrowsExceptionWhenArticleIsNotFound()
    {
        $post = $this->blog->getById('does-not-exist');
    }

    public function testCanGetArticleById()
    {
        $this->assertInstanceOf(
            Article::class,
            $this->blog->getById('post-title')
        );
    }
}
