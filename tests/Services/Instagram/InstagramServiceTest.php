<?php

namespace App\Tests\Services\Instagram;

use App\Services\Instagram\Connections\Connection;
use App\Services\Instagram\Connections\ConnectionInterface;
use App\Services\Instagram\InstagramService;
use App\Tests\AbstractTestCase;
use App\Tests\Services\Instagram\Connections\Providers\Fixtures\StaticContent as StaticContentProvider;

class TwitterServiceTest extends AbstractTestCase
{
    /**
     * @return InstagramService
     */
    private function getService()
    {
        return new InstagramService(
            new Connection(
                new StaticContentProvider()
            )
        );
    }

    /**
     * @test
     * @group instagram
     */
    public function itReturnsTheCorrectConnectionImplementation()
    {
        $this->assertInstanceOf(
            ConnectionInterface::class,
            $this->getService()->getConnection()
        );
    }
}
