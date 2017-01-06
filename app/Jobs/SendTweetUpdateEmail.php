<?php

namespace App\Jobs;

use Config;
use App\Jobs\Job;
use App\Services\Twitter\Tweet;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTweetUpdateEmail extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue;

    /**
     * @var Tweet
     */
    private $tweet;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     * 
     * @param Mailer $mailer
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {

        $mailer->send(
            'emails.tweet',
            [
                'tweet' => $this->tweet
            ],
            function($message) {
                $message
                    ->from(
                        Config::get('site.meta.email.from'),
                        'Portfolio'
                    )
                    ->to(
                        Config::get('site.meta.email.to'),
                        Config::get('site.meta.title')
                    )
                    ->subject(
                        'Tweet Update'
                    );
            }
        );
    }

}
