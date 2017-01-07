<?php

namespace App\Services\Twitter\Jobs;

use Mail;
use Config;
use App\Services\Twitter\Tweet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Twitter\Mail\TweetUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTweetUpdate implements ShouldQueue
{

    use Queueable, InteractsWithQueue;

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
     * @return void
     */
    public function handle(Mail $mail)
    {
        Mail::to(
            collect([
                [
                    'email' => Config::get('site.meta.email.to'),
                    'name' => Config::get('site.meta.title')
                ]
            ])
        )
        ->send(
            new TweetUpdate($this->tweet)
        );
    }

}
