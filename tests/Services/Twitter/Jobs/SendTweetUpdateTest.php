<?php

namespace App\Tests\Services\Twitter\Jobs;

use App\Services\Twitter\Jobs\SendTweetUpdate;
use App\Services\Twitter\Mail\TweetUpdate;
use App\Services\Twitter\TweetManager;
use App\Tests\AbstractTestCase;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Mail;

class SendTweetUpdateTest extends AbstractTestCase
{
    use DispatchesJobs;

    /**
     * @test
     * @group twitter
     */
    public function itCorrectlySendsTheEmail()
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
