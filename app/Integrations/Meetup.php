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
     * @return Event
     */
    public static function createEventFromArray(array $event)
    {
        return Event::make(
            array_get($event, 'id'),
            array_get($event, 'name'),
            array_get($event, 'link'),
            array_get($event, 'time'),
            array_get($event, 'group.name', false),
            array_get($event, 'venue.name', false),
            array_get($event, 'yes_rsvp_count', 0),
            array_get($event, 'status', 'past')
        );
    }

    /**
     * Store event within the cache forever.
     *
     * @param  Event  $event
     * @return void
     */
    public static function storeEvent(Event $event)
    {
        Cache::forever(self::CACHE_NAME, $event);
    }

    /**
     * Return the latest meetup event stored within the cache.
     *
     * @return array|boolean
     */
    public static function getEvent()
    {
        return Cache::get(self::CACHE_NAME, []);
    }

    /**
     * Forget any content that's stored within the cache.
     *
     * @return void
     */
    public static function clearStored()
    {
        Cache::forget(self::CACHE_NAME);
    }

}
