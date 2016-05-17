<?php

namespace App\Console\Commands;

use Log;
use Config;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\Integrations\Meetup as MeetupIntegration;

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
     * Retrieve the Meetup API Key
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
                        'key'  => $this->getKey(),
                        'sign' => true
                    ]
                ]
            );

            if ($response->getStatusCode() == 200) {

                $data = $response->json();

                if ($data && is_array($data)) {

                    $events = [];
                    foreach ($data as $eventData) {

                        $event = MeetupIntegration::createEventFromArray($eventData);

                        if (!$event->hasPassed()) {
                            $events[] = $event;
                        }

                    }

                    MeetupIntegration::storeEvents($events);

                }

            }

        } catch (Exception $e ) {
            Log::error($e);
        }

        return [];

    }

}
