<?php

namespace App\Domain\Storage;

use Cache;

class StorageManager
{
    /**
     * @var string
     */
    const CACHE_NAME = 'storage.%s';

    /**
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCacheName()
    {
        return sprintf(
            static::CACHE_NAME,
            $this->getId()
        );
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return Cache::get(
            $this->getCacheName(),
            []
        );
    }

    /**
     * @param string $id
     *
     * @return StorageManager
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items = [])
    {
        Cache::forever(
            $this->getCacheName(),
            $items
        );
    }
}
