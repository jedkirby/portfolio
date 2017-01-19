<?php

namespace App\Services\Twitter\Jobs;

use App\Services\Twitter\Entity\Tweet;
use App\Services\Twitter\Mail\TweetUpdate;
use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendTweetUpdate implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    /**
     * @var Tweet
     */
    private $tweet;

    /**
     * Create a new job instance.
     */
    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     */
    public function handle(Mail $mail)
    {
        Mail::to(
            collect([
                [
                    'email' => Config::get('site.meta.email.to'),
                    'name' => Config::get('site.meta.title'),
                ],
            ])
        )
        ->send(
            new TweetUpdate($this->tweet)
        );
    }
}
