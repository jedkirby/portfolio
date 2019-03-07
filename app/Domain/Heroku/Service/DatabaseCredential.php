<?php

namespace App\Domain\Heroku\Service;

class DatabaseCredential
{
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return env('CLEARDB_DATABASE_URL', '');
    }

    /**
     * @return bool
     */
    public function hasUrl(): bool
    {
        return (bool) $this->getUrl();
    }

    /**
     * Breakdown the URL string into it's parts.
     *
     * @return array
     */
    public function getCredentials(): array
    {
        $url = parse_url(
            $this->getUrl()
        );

        return [
            'host' => array_get($url, 'host'),
            'port' => array_get($url, 'port', 3306),
            'database' => substr(array_get($url, 'path'), 1),
            'username' => array_get($url, 'user'),
            'password' => array_get($url, 'pass'),
        ];
    }
}
