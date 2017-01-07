<?php

namespace App\Services\Twitter\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Services\Twitter\Tweet;

class TweetUpdate extends Mailable
{

    use Queueable;

    /**
     * @var Tweet
     */
    public $tweet;

    /**
     * @param Tweet $tweet
     */
    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('emails.tweet')
            ->subject('Tweet Update')
            ->with([
                'tweet' => $this->tweet
            ]);
    }

}