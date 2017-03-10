<?php

namespace App\Domain\Service\Instagram\Entity;

class Post
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string|bool
     */
    private $text;

    private function __construct($id, $link, $image, $text)
    {
        $this->id = (string) $id;
        $this->link = (string) $link;
        $this->image = (string) $image;
        $this->text = $text;
    }

    /**
     * @param string $id
     * @param string $link
     * @param string $image
     * @param string|bool $text
     */
    public static function make($id, $link, $image, $text = false)
    {
        return new self($id, $link, $image, $text);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (string) $this->id;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return (string) $this->link;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return (string) $this->image;
    }

    /**
     * @param string $default
     *
     * @return string
     */
    public function getText($default = '')
    {
        return (string) ($this->hasText() ? $this->text : $default);
    }

    /**
     * @return bool
     */
    public function hasText()
    {
        return (bool) $this->text;
    }
}
