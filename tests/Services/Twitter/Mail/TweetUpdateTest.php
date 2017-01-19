<?php

namespace App\Tests\Services\Twitter\Mail;

use App\Services\Twitter\Mail\TweetUpdate;
use App\Services\Twitter\TweetManager;
use App\Tests\AbstractTestCase;

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

        $this->assertEquals(
            $mail->subject,
            'Tweet Update'
        );

        $this->assertEquals(
            $mail->view,
            'emails.tweet'
        );
    }
}
