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
    private $groupName;
    private $venueName;
    private $rsvpCount;

    /**
     * Constructor.
     */
    private function __construct($id, $name, $link, $groupName, $venueName, $rsvpCount)
    {
        $this->id = (int) $id;
        $this->name = (string) $name;
        $this->link = (string) $link;
        $this->groupName = (string) $groupName;
        $this->venueName = (string) $venueName;
        $this->rsvpCount = (int) $rsvpCount;
    }

    /**
     * Make command used for chaining.
     *
     * @param  int  $id
     * @param  string  $name
     * @param  string  $link
     * @param  boolean $groupName
     * @param  boolean $venueName
     * @param  integer $rsvpCount
     * @return \App\Integrations\Meetup\Event
     */
    public static function make($id, $name, $link, $groupName = false, $venueName = false, $rsvpCount = 0)
    {
        return new self($id, $name, $link, $groupName, $venueName, $rsvpCount);
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

}
