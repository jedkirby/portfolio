<?php

namespace App\Tests\Services\Twitter;

use App\Services\Twitter\Connections\Connection;
use App\Services\Twitter\Connections\ConnectionInterface;
use App\Services\Twitter\TwitterService;
use App\Tests\AbstractTestCase;
use App\Tests\Services\Twitter\Connections\Providers\Fixtures\StaticContent as StaticContentProvider;

class TwitterServiceTest extends AbstractTestCase
{
    /**
     * @return TwitterService
     */
    private function getService()
    {
        return new TwitterService(
            new Connection(
                new StaticContentProvider
            )
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnsTheCorrectConnectionImplementation()
    {
        $this->assertInstanceOf(
            ConnectionInterface::class,
            $this->getService()->getConnection()
        );
    }
}
