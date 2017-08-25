<?php

namespace App\Providers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\Writer as Log;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\SlackWebhookHandler;
use Monolog\Logger;

class SlackLoggingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the Slack logging handler.
     *
     * @param Log $logger
     * @param Config $config
     * @param Application $app
     */
    public function boot(
        Log $logger,
        Config $config,
        Application $app
    ) {
        if ($app->environment(['production', 'staging'])) {
            $webhook = $config->get('services.slack.webhook');
            if ($webhook) {
                $logger->getMonolog()->pushHandler(new SlackWebhookHandler(
                    $webhook,       // Slack Webhook URL
                    null,           // Slack channel (encoded ID or name)
                    null,           // Name of a bot
                    true,           // Whether the message should be added to Slack as attachment (plain text otherwise)
                    null,           // The emoji name to use (or null)
                    false,          // Whether the the context/extra messages added to Slack as attachments are in a short style
                    true,           // Whether the attachment should include context and extra data
                    Logger::ERROR   // The minimum logging level at which this handler will be triggered
                ));
            }
        }
    }
}
