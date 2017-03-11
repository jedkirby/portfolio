<?php

namespace App\Tests\Domain\Project;

use App\Domain\Project\Entity\PostInterface;
use App\Domain\Project\ProjectManager;
use App\Tests\AbstractTestCase as TestCase;

/**
 * @group domain
 * @group domain.project
 * @group domain.project.manager
 */
class ProjectManagerTest extends TestCase
{
    private $manager;

    public function __construct()
    {
        $this->manager = new ProjectManager();
    }

    public function testGetPostsReturnsAnArray()
    {
        $this->assertInternalType(
            'array',
            $this->manager->getPosts()
        );
    }

    public function testCountMatchesAllPostCount()
    {
        $this->assertCount(
            $this->manager->getPostsCount(),
            $this->manager->getPosts()
        );
    }

    public function testCanLimitPostsReturned()
    {
        $this->assertCount(
            5,
            $this->manager->getPosts(5)
        );
    }

    public function testGettingPostsReturnsInstancesOfPostInterface()
    {
        $posts = $this->manager->getPosts();

        foreach ($posts as $id => $post) {
            $this->assertInstanceOf(
                PostInterface::class,
                $post
            );
        }
    }

    public function testCanGetSinglePost()
    {
        $this->assertInstanceOf(
            PostInterface::class,
            $this->manager->getPost('victoria-jeffs')
        );
    }

    /**
     * @expectedException \App\Domain\Project\Exception\PostNotFoundException
     */
    public function testExceptionIsThrownWhenPostDoesNotExist()
    {
        $this->manager->getPost('this-does-not-exist');
    }
}
