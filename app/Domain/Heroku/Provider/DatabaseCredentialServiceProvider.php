<?php

namespace App\Domain\Heroku\Provider;

use App\Domain\Heroku\Service\DatabaseCredential;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

/**
 * @codeCoverageIgnore
 */
class DatabaseCredentialServiceProvider extends ServiceProvider
{
    /**
     * This will overwrite the database connection details if
     * Heroku has a database url defined. This is required
     * because Heroku will often change the URL to the database.
     *
     * @param DatabaseCredential $service
     * @param Config $config
     * @param DatabaseManager $db
     */
    public function boot(
        DatabaseCredential $service,
        Config $config,
        DatabaseManager $db
    ) {
        $prefix = sprintf(
            'database.connections.%s',
            $config->get('database.default')
        );

        if ($service->hasUrl()) {
            $credentials = $service->getCredentials();

            foreach ($credentials as $key => $value) {
                $config->set(
                    implode('.', [$prefix, $key]),
                    $value
                );
            }

            $db->reconnect();
        }
    }
}
