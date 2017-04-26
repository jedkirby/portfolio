<?php

namespace App\Domain\Service\Twitter\Console\Command;

use App\Domain\Service\Twitter\Jobs\SendTweetUpdate;
use App\Domain\Service\Twitter\TweetManager;
use App\Domain\Service\Twitter\TwitterService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bus\DispatchesJobs;

class LatestTweet extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'twitter:latest-tweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch or update the latest relevant tweet';

    /**
     * @var Application
     */
    protected $app;

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
    public function __construct(
        Application $app,
        TwitterService $service,
        TweetManager $manager
    ) {
        parent::__construct();

        $this->app = $app;
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
            if (
                $this->manager->hasTweetChanged($tweet) &&
                $this->app->environment('production')
            ) {
                $this->dispatch(new SendTweetUpdate($tweet));
            }

            $this->manager->setTweet($tweet);
        }
    }
}
