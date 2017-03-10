<?php

namespace App\Domain\Service\Instagram\Command;

use App\Domain\Service\Instagram\InstagramManager;
use App\Domain\Service\Instagram\InstagramService;
use Illuminate\Console\Command;

class LatestPosts extends Command
{
    /**
     * The amount of posts to store.
     *
     * @var int
     */
    const POST_LIMIT = 12;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'instagram:latest-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the latest instagram posts';

    /**
     * @var InstagramService
     */
    protected $service;

    /**
     * @var InstagramManager
     */
    protected $manager;

    /**
     * Create a new command instance.
     */
    public function __construct(InstagramService $service, InstagramManager $manager)
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
        $feed = $this->service->getConnection()->getFeed();

        $posts = $this->manager->getAllowedPosts(
            $feed,
            self::POST_LIMIT,
            $this->manager->getIgnoredIds()
        );

        if ($posts) {
            $this->manager->setPosts($posts);
        }
    }
}
