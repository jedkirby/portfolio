<?php

namespace App\Domain\Heroku\Provider;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class DatabaseDefaultSchemaSettingsServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
