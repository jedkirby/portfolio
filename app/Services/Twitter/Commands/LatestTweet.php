<?php

namespace App\Services\Twitter\Commands;

use App\Services\Twitter\Jobs\SendTweetUpdate;
use App\Services\Twitter\TweetManager;
use App\Services\Twitter\TwitterService;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class LatestTweet extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:latest-tweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch or update the latest relevant tweet.';

    /**
     * @var TwitterService
     */
    protected $service;

    /**
     * @var TweetManager
     */
    protected $manager;

    /**
     * Create a new command instance.
     */
    public function __construct(TwitterService $service, TweetManager $manager)
    {
        parent::__construct();

        $this->service = $service;
        $this->manager = $manager;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $timeline = $this->service->getConnection()->getTimeline();
        $allowedHashtags = $this->manager->getAllowedHashtags();

        if ($tweet = $this->manager->getLatestTweet($timeline, $allowedHashtags)) {
            if ($this->manager->hasTweetChanged($tweet)) {
                $this->dispatch(new SendTweetUpdate($tweet));
            }

            $this->manager->setTweet($tweet);
        }
    }
}
