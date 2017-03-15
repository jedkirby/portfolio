<?php

namespace App\Tests\Domain\Service\Instagram;

use App\Domain\Service\Instagram\Connection\Connection;
use App\Domain\Service\Instagram\Connection\ConnectionInterface;
use App\Domain\Service\Instagram\InstagramService;
use App\Tests\AbstractAppTestCase as TestCase;
use App\Tests\Domain\Service\Instagram\Connection\Provider\Fixtures\StaticContent as StaticContentProvider;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.instagram
 * @group domain.service.instagram.service
 */
class TwitterServiceTest extends TestCase
{
    private function getService()
    {
        return new InstagramService(
            new Connection(
                new StaticContentProvider()
            )
        );
    }

    public function testItReturnsTheCorrectConnectionImplementation()
    {
        $this->assertInstanceOf(
            ConnectionInterface::class,
            $this->getService()->getConnection()
        );
    }
}
