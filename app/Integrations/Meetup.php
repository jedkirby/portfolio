<?php

namespace App\Integrations;

use Cache;
use App\Integrations\Meetup\Event;

class Meetup
{

    /**
     * Cache Namespace
     */
    const CACHE_NAME = 'meetups';

    /**
     * Create an event from a given array.
     *
     * @param  array  $event
     * @return \App\Integrations\Meetup\Event
     */
    public static function createEventFromArray(array $event)
    {
        return Event::make(
            array_get($event, 'id'),
            array_get($event, 'name'),
            array_get($event, 'link'),
            array_get($event, 'group.name', false),
            array_get($event, 'venue.name', false),
            array_get($event, 'yes_rsvp_count', 0)
        );
    }

    /**
     * Store events within the cache forever.
     *
     * @param  array  $events
     * @return void
     */
    public static function storeEvents(array $events)
    {
        Cache::forever(self::CACHE_NAME, $events);
    }

    /**
     * Return the meetup events stored within the cache.
     *
     * @return array|boolean
     */
    public static function getEvents()
    {
        return Cache::get(self::CACHE_NAME, []);
    }

}
