<?php

namespace App\Domain\Handler\Error\Console\Command;

use Illuminate\Console\Command;

class ErrorReport extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:error-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detect application errors and notify administrators.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        dd(__METHOD__);
    }
}
