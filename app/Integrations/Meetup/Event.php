<?php

namespace App\Integrations\Meetup;

class Event
{

    /**
     * Event Data.
     */
    private $id;
    private $name;
    private $link;
    private $time;
    private $groupName;
    private $venueName;
    private $rsvpCount;
    private $status;

    /**
     * Constructor.
     */
    private function __construct($id, $name, $link, $time, $groupName, $venueName, $rsvpCount, $status)
    {
        $this->id = (int) $id;
        $this->name = (string) $name;
        $this->link = (string) $link;
        $this->time = (int) $time;
        $this->groupName = (string) $groupName;
        $this->venueName = (string) $venueName;
        $this->rsvpCount = (int) $rsvpCount;
        $this->status = (string) $status;
    }

    /**
     * Make command used for chaining.
     *
     * @param  int  $id
     * @param  string  $name
     * @param  string  $link
     * @param  integer $time
     * @param  boolean $groupName
     * @param  boolean $venueName
     * @param  integer $rsvpCount
     * @param  string  $status
     * @return \App\Integrations\Meetup\Event
     */
    public static function make($id, $name, $link, $time, $groupName = false, $venueName = false, $rsvpCount = 0, $status = 'past')
    {
        return new self($id, $name, $link, $time, $groupName, $venueName, $rsvpCount, $status);
    }

    /**
     * Return the ID.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return the link.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Return the group name.
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Return the venue name.
     *
     * @return string
     */
    public function getVenueName()
    {
        return $this->venueName;
    }

    /**
     * Return the confirmed RSVP count.
     *
     * @return int
     */
    public function getRsvpCount()
    {
        return $this->rsvpCount;
    }

    /**
     * Return the status of the event.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return the time of the event as a timestamp.
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Return if there is a group assigned.
     *
     * @return boolean
     */
    public function hasGroup()
    {
        return (bool) $this->getGroupName();
    }

    /**
     * Return if there is a venue assigned.
     *
     * @return boolean
     */
    public function hasVenue()
    {
        return (bool) $this->getVenueName();
    }

    /**
     * Return if the event has passed already.
     *
     * @return boolean
     */
    public function hasPassed()
    {
        return in_array($this->getStatus(), array('past'));
    }

}
