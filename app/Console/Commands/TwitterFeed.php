<?php

namespace App\Console\Commands;

use App\Jobs\FetchTwitterFeed;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TwitterFeed extends Command
{

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:tweets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the latest twitter home timeline.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->dispatch(new FetchTwitterFeed);
    }

}
