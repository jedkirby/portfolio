<?php

namespace App\Tests\Providers;

use App\Providers\SlackLoggingServiceProvider;
use App\Tests\AbstractTestCase as TestCase;
use Illuminate\Console\Application as ConsoleApplication;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\Writer as Log;
use Mockery;
use Monolog\Handler\SlackWebhookHandler;
use Monolog\Logger;

/**
 * @group providers
 * @group providers.slack
 */
class SlackLoggingServiceProviderTest extends TestCase
{
    const SLACK_WEBHOOK = 'https://hooks.slack.com/services/123456789/987654321';

    private $app;
    private $logger;
    private $config;
    private $provider;

    public function setUp()
    {
        $this->app = Mockery::mock(Application::class);
        $this->logger = Mockery::mock(Log::class);
        $this->config = Mockery::mock(Config::class);
        $this->provider = new SlackLoggingServiceProvider(
            Mockery::mock(ConsoleApplication::class)
        );
    }

    public function testHandlerIsNotAddedIfNotOnCorrectEnvironment()
    {
        $this->app
            ->shouldReceive('environment')
            ->with('production')
            ->andReturn(false)
            ->once();

        $this->app->shouldNotReceive('get')->with('services.slack.webhook');

        $this->logger->shouldNotReceive('getMonolog');

        $this->provider->boot(
            $this->logger,
            $this->config,
            $this->app
        );
    }

    public function testHandlerIsNotAddedIfThereIsNoTokenOrChannel()
    {
        $this->app
            ->shouldReceive('environment')
            ->with('production')
            ->andReturn(true)
            ->once();

        $this->config
            ->shouldReceive('get')
            ->with('services.slack.webhook')
            ->andReturn(null)
            ->once();

        $this->logger->shouldNotReceive('getMonolog');

        $this->provider->boot(
            $this->logger,
            $this->config,
            $this->app
        );
    }

    public function testHandlerIsAddedWithTokenAndChannel()
    {
        $this->app
            ->shouldReceive('environment')
            ->with('production')
            ->andReturn(true)
            ->once();

        $this->config
            ->shouldReceive('get')
            ->with('services.slack.webhook')
            ->andReturn(static::SLACK_WEBHOOK)
            ->once();

        $monolog = Mockery::mock(Logger::class);
        $monolog
            ->shouldReceive('pushHandler')
            ->with(Mockery::type(SlackWebhookHandler::class))
            ->once();

        $this->logger
            ->shouldReceive('getMonolog')
            ->andReturn($monolog)
            ->once();

        $this->provider->boot(
            $this->logger,
            $this->config,
            $this->app
        );
    }
}
