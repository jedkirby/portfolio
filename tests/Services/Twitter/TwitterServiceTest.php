<?php

namespace Test\App\Services\Twitter;

use Test\App\AbstractTestCase;
use App\Services\Twitter\TwitterService;
use Test\App\Services\Twitter\Connections\NullConnection;

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
