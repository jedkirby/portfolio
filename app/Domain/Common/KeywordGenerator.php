<?php

namespace App\Domain\Common;

class KeywordGenerator
{
    /**
     * @var int
     */
    const DEFAULT_LIMIT = 15;

    /**
     * @var array
     */
    private $keywords;

    /**
     * @var int
     */
    private $limit;

    /**
     * @param array $keywords
     * @param int $limit
     */
    public function __construct(
        array $keywords = [],
        $limit = self::DEFAULT_LIMIT
    ) {
        $this->keywords = (array) $keywords;
        $this->limit = (int) $limit;
    }

    /**
     * Generate the string list of keywords using the array passed to the constructor.
     *
     * @return string
     */
    public function run()
    {
        $keywords = $this->keywords;
        $keywords = array_unique($keywords);

        if ($this->limit) {
            $keywords = array_slice($keywords, 0, $this->limit);
        }

        return implode(', ', $keywords);
    }
}
