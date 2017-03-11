<?php

namespace App\Domain\Project\Entity;

use Carbon\Carbon;
use Illuminate\View\View;

/**
 * @codeCoverageIgnore
 */
interface PostInterface
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getSubTitle();

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @return Carbon
     */
    public function getDate();

    /**
     * @return View
     */
    public function getIntroduction();

    /**
     * @return View
     */
    public function getContent();

    /**
     * @return View|bool
     */
    public function getTestimonial();

    /**
     * @return string
     */
    public function getLink();

    /**
     * @return string|bool
     */
    public function getExpired();

    /**
     * @return array
     */
    public function getKeywords();

    /**
     * @return string
     */
    public function getHero();

    /**
     * @return array
     */
    public function getImages();
}
