<?php

namespace Test\App\Services\Twitter\Mail;

use Test\App\AbstractTestCase;
use App\Services\Twitter\TweetManager;
use App\Services\Twitter\Mail\TweetUpdate;

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