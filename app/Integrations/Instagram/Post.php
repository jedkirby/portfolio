<?php

namespace App\Integrations\Instagram;

class Post
{

    /**
     * Post Data.
     */
    private $id;
    private $link;
    private $image;
    private $text;

    /**
     * Constructor.
     */
    private function __construct($id, $link, $image, $text = false)
    {
        $this->id = (string) $id;
        $this->link = (string) $link;
        $this->image = (string) $image;
        $this->text = $text;
    }

    /**
     * Make command used for chaining.
     *
     * @param string $id
     * @param string $link
     * @param string $image
     * @param boolean|string $text
     * @return Post
     */
    public static function make($id, $link, $image, $text = false)
    {
        return new self($id, $link, $image, $text);
    }

    /**
     * Return the ID.
     *
     * @return string
     */
    public function getId()
    {
        return (string) $this->id;
    }

    /**
     * Return the link.
     *
     * @return string
     */
    public function getLink()
    {
        return (string) $this->link;
    }

    /**
     * Return the path to the image.
     *
     * @return string
     */
    public function getImage()
    {
        return (string) $this->image;
    }

    /**
     * Return the text.
     *
     * @param string $default
     * @return string
     */
    public function getText($default = '')
    {
        return (string) ($this->hasText() ? $this->text : $default);
    }

    /**
     * Return whether there's text or not.
     *
     * @return bool
     */
    public function hasText()
    {
        return (bool) $this->text;
    }

}
