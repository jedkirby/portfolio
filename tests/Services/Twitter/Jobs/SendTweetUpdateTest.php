<?php

namespace Test\App\Services\Twitter\Jobs;

use Mail;
use Mockery;
use Test\App\AbstractTestCase;
use App\Services\Twitter\Mail\TweetUpdate;
use App\Services\Twitter\TweetManager;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Services\Twitter\Jobs\SendTweetUpdate;

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
