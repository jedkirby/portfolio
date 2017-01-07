<?php

namespace Test\App\Services\Twitter\Mail;

use App\Services\Twitter\Mail\TweetUpdate;
use App\Services\Twitter\TweetManager;
use Test\App\AbstractTestCase;

class TweetUpdateTest extends AbstractTestCase
{
    /**
     * @test
     * @group twitter
     */
    public function itCreatesTheEmailAndAttachesTheTweet()
    {
        $tweet = TweetManager::createFromArray(['id' => 1, 'text' => __CLASS__]);

        $mail = new TweetUpdate($tweet);
        $mail = $mail->build();

        $this->assertEquals(
            $mail->tweet,
            $tweet
        );
    }
}
