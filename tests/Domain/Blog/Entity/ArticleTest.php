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
        $this->assertEquals($entity->getDate(), '2001-03-10');
        $this->assertEquals($entity->getSnippet(), 'Post Snippet.');
        $this->assertInstanceOf(View::class, $entity->getContent());
        $this->assertStringStartsWith('http://localhost/assets/tests/sample.png', $entity->getImage());
        $this->assertEquals($entity->getKeywords(), ['One', 'Two']);
        $this->assertEquals($entity->getUrl(), 'http://localhost/blog/post-title');
    }

    public function dateFormatProvider()
    {
        return [
            ['F j, Y, g:i a', 'March 10, 2001, 5:16 pm'],
            ['m.d.y', '03.10.01'],
            ['j, n, Y', '10, 3, 2001'],
            ['Ymd', '20010310'],
            ['h-i-s, j-m-y, it is w Day', '05-16-18, 10-03-01, 1631 1618 6 Satpm01'],
            ['\i\t \i\s \t\h\e jS \d\a\y.', 'it is the 10th day.'],
            ['H:m:s \m \i\s\ \m\o\n\t\h', '17:03:18 m is month'],
            ['H:i:s', '17:16:18'],
            ['Y-m-d H:i:s', '2001-03-10 17:16:18'],
        ];
    }

    /**
     * @dataProvider dateFormatProvider
     */
    public function testCanFormatDate($format, $expected)
    {
        $entity = $this->createEntity();

        $this->assertEquals(
            $entity->getDate($format),
            $expected
        );
    }
}
