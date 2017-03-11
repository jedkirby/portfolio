<?php

namespace App\Tests\Domain\Project;

use App\Domain\Project\ProjectManager;
use App\Tests\AbstractAppTestCase as TestCase;

/**
 * @group domain
 * @group domain.project
 */
class SampleTest extends TestCase
{
    public function testThis()
    {
        $manager = new ProjectManager();

        $post = $manager->getPost('victoria-jeffs');

        dd(
            $post->getTitle(),
            $post->getSubTitle(),
            $post->getIcon(),
            $post->getDate(),
            $post->getIntroduction(),
            $post->getContent(),
            $post->getTestimonial(),
            $post->getLink(),
            $post->getKeywords(),
            $post->getHero(),
            $post->getImages(),
            $post->isExpired()
        );
    }
}
