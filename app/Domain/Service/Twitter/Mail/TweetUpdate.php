<?php

namespace App\Domain\Service\Twitter\Mail;

use App\Domain\Service\Twitter\Entity\Tweet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

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
                'tweet' => $this->tweet,
            ]);
    }
}
