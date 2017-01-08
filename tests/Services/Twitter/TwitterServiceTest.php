<?php

namespace App\Tests\Services\Twitter;

use App\Services\Twitter\TwitterService;
use App\Tests\AbstractTestCase;
use App\Tests\Services\Twitter\Connections\NullConnection;

class TwitterServiceTest extends AbstractTestCase
{
    /**
     * @return TwitterService
     */
    private function getService()
    {
        return new TwitterService(
            new NullConnection()
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnsTheCorrectConnection()
    {
        $this->assertInstanceOf(
            NullConnection::class,
            $this->getService()->getConnection()
        );
    }
}
