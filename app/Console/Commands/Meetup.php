<?php

namespace App\Console\Commands;

use App\Integrations\Meetup as MeetupIntegration;
use Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Log;

class Meetup extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:meetup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the latest meetup event(s) I am attending.';

    /**
     * Retrieve the Meetup API Key.
     *
     * @return string
     */
    protected function getKey()
    {
        return Config::get('site.social.streams.meetup.api.key');
    }

    /**
     * Return a new Guzzle Client.
     *
     * @return Client
     */
    protected function getClient()
    {
        return new Client();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        try {
            $response = $this->getClient()->get(
                'https://api.meetup.com/self/events',
                [
                    'query' => [
                        'key' => $this->getKey(),
                        'sign' => true,
                    ],
                ]
            );

            if ($response->getStatusCode() == 200) {
                $data = $response->json();

                if ($data && is_array($data)) {
                    $events = [];

                    foreach ($data as $eventData) {
                        $event = MeetupIntegration::createEventFromArray($eventData);
                        if ($event->hasPassed()) {
                            continue;
                        }

                        $events[
                            $event->getTime()
                        ] = $event;
                    }

                    if ($events) {
                        ksort($events);

                        $latestEvent = head($events);

                        MeetupIntegration::storeEvent($latestEvent);

                        // Give some output
                        $this->info('Latest Meetup event fetched!');
                    } else {
                        MeetupIntegration::clearStored();

                        // We got nothin'
                        $this->info('There are no upcoming Meetup events.');
                    }
                }
            }
        } catch (Exception $e) {
            // Bit of logging
            Log::error($e);

            // We have an issue
            $this->info('Failed to fetch Meetup events.');
        }
    }
}
