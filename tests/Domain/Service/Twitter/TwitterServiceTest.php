<?php

namespace App\Tests\Domain\Service\Twitter;

use App\Domain\Service\Twitter\Connection\Connection;
use App\Domain\Service\Twitter\Connection\ConnectionInterface;
use App\Domain\Service\Twitter\TwitterService;
use App\Tests\AbstractTestCase as TestCase;
use App\Tests\Domain\Service\Twitter\Connection\Provider\Fixtures\StaticContent as StaticContentProvider;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.twitter
 * @group domain.service.twitter.service
 */
class TwitterServiceTest extends TestCase
{
    private function getService()
    {
        return new TwitterService(
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
