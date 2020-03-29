<?php

namespace App\Tests\Domain\Project\Entity;

use App\Domain\Project\Entity\Post;
use App\Tests\AbstractAppTestCase as TestCase;
use Carbon\Carbon;
use Illuminate\View\View;

/**
 * @group domain
 * @group domain.project
 * @group domain.project.entity
 * @group domain.project.entity.post
 */
class PostTest extends TestCase
{
    private function createEntity()
    {
        return new Post(
            'project-title',
            'Project Title',
            'Project Sub Title',
            'fa fa-icon',
            Carbon::create(2001, 3, 10, 17, 16, 18),
            'tests.sample',
            'tests.sample',
            false,
            'http://test.com',
            false,
            'assets/tests/sample.png',
            [
                'One',
                'Two',
            ],
            [
                'assets/tests/sample.png',
                'assets/tests/sample.png',
            ]
        );
    }

    public function testPropertiesAreCorrect()
    {
        $entity = $this->createEntity();

        $this->assertEquals($entity->getId(), 'project-title');
        $this->assertEquals($entity->getTitle(), 'Project Title');
        $this->assertEquals($entity->getSubtitle(), 'Project Sub Title');
        $this->assertEquals($entity->getIcon(), 'fa fa-icon');
        $this->assertEquals($entity->getDate(), '2001-03-10');
        $this->assertInstanceOf(View::class, $entity->getIntroduction());
        $this->assertEquals($entity->getIntroductionForMeta(), 'Hello, World!');
        $this->assertInstanceOf(View::class, $entity->getContent());
        $this->assertEquals($entity->getTestimonial(), false);
        $this->assertEquals($entity->getLink(), 'http://test.com');
        $this->assertEquals($entity->getExpired(), false);
        $this->assertStringStartsWith('http://jedkirby.testing/assets/tests/sample.png', $entity->getHero());
        $this->assertEquals($entity->getKeywords(), ['One', 'Two']);
        $this->assertEquals($entity->getUrl(), 'http://jedkirby.testing/work/project-title');

        foreach ($entity->getImages() as $image) {
            $this->assertStringStartsWith('http://jedkirby.testing/assets/tests/sample.png', $image);
        }
    }
}
