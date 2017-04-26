<?php

namespace App\Tests\Domain\Service\Twitter\Mail;

use App\Domain\Service\Twitter\Mail\TweetUpdate;
use App\Domain\Service\Twitter\TweetManager;
use App\Tests\AbstractAppTestCase as TestCase;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.twitter
 * @group domain.service.twitter.mail
 */
class TweetUpdateTest extends TestCase
{
    public function testItCreatesTheEmailAndAttachesTheTweet()
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
