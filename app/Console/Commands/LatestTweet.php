<?php

namespace App\Console\Commands;

use Config;
use Illuminate\Console\Command;
use App\Services\Twitter\TweetManager;
use App\Services\Twitter\TwitterService;

class LatestTweet extends Command
{

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
     *
     * @return void
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
            $this->manager->setTweet($tweet);
        }


    }

}
