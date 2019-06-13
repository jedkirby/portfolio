<?php

namespace App\Tests\Domain\Blog\Entity;

use App\Domain\Blog\Entity\Article;
use App\Tests\AbstractAppTestCase as TestCase;
use Carbon\Carbon;
use Illuminate\View\View;

/**
 * @group domain
 * @group domain.blog
 * @group domain.blog.entity
 * @group domain.blog.entity.article
 */
class ArticleTest extends TestCase
{
    private function createEntity()
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

    public function testPropertiesAreCorrect()
    {
        $entity = $this->createEntity();

        $this->assertEquals($entity->getId(), 'post-title');
        $this->assertEquals($entity->getTitle(), 'Post Title');
        $this->assertEquals($entity->getDateForHuman(), 'March 10, 2001');
        $this->assertEquals($entity->getDateForMeta(), '2001-03-10');
        $this->assertEquals($entity->getSnippet(), 'Post Snippet.');
        $this->assertInstanceOf(View::class, $entity->getContent());
        $this->assertStringStartsWith('http://localhost/assets/tests/sample.png', $entity->getImage());
        $this->assertEquals($entity->getKeywords(), ['One', 'Two']);
        $this->assertEquals($entity->getUrl(), 'http://localhost/blog/post-title');
    }
}
