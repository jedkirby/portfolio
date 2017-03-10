<?php

namespace App\Tests\Domain\Service\Twitter\Jobs;

use App\Domain\Service\Twitter\Jobs\SendTweetUpdate;
use App\Domain\Service\Twitter\Mail\TweetUpdate;
use App\Domain\Service\Twitter\TweetManager;
use App\Tests\AbstractAppTestCase as TestCase;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Mail;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.twitter
 * @group domain.service.twitter.jobs
 */
class SendTweetUpdateTest extends TestCase
{
    use DispatchesJobs;

    public function testItCorrectlySendsTheEmail()
    {
        Mail::fake();

        $tweet = TweetManager::createFromArray(['id' => 1, 'text' => 'First Tweet']);
        $job = new SendTweetUpdate($tweet);

        $this->dispatch($job);

        Mail::assertSent(
            TweetUpdate::class,
            function ($mail) use ($tweet) {
                return $mail->tweet->getId() === $tweet->getId();
            }
        );
    }
}
