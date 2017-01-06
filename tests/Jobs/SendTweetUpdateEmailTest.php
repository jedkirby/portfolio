<?php

namespace Test\App\Jobs;

use Mockery;
use Test\App\AbstractTestCase;
use App\Jobs\SendTweetUpdateEmail;
use Illuminate\Contracts\Mail\Mailer;
use App\Services\Twitter\TweetManager;

class SendTweetUpdateEmailTest extends AbstractTestCase
{

    /**
     * @test
     * @group twitter
     */
    public function itTests()
    {

        $tweet = TweetManager::createFromArray(['id' => 1, 'text' => 'First Tweet']);
        $job = new SendTweetUpdateEmail($tweet);

        $mailer = Mockery::mock(Mailer::class);

        // $job->handle($mailer);

    }

}
