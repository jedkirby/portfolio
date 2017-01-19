<?php

use Illuminate\Database\Migrations\Migration;

class ForceConsoleTasks extends Migration
{

    /**
     * Array of commands to process.
     */
    const COMMANDS = [
        'cache:clear',
        'instagram:latest-posts',
        'twitter:latest-tweet'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (self::COMMANDS as $command) {
            Artisan::call($command);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No need for a down.
    }

}
