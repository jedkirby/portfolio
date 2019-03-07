<?php

namespace App\Domain\Cloudflare\Service;

use Exception;
use Illuminate\Cache\Repository as Cache;

class Cloudflare
{
    /**
     * @var string
     */
    const PROXY_URL = 'https://www.cloudflare.com/ips-v4';

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @param Cache $cache
     */
    public function __construct(
        Cache $cache
    ) {
        $this->cache = $cache;
    }

    /**
     * Return the Cloudflare proxy ip's, but, cache them for a while.
     *
     * @return array
     */
    public function getProxyIps(): array
    {
        $ips = [];
        $key = __METHOD__;

        if (!$this->cache->has($key)) {
            try {
                $ips = array_filter(
                    explode(
                        "\n",
                        file_get_contents(
                            static::PROXY_URL
                        )
                    )
                );

                if ($ips) {
                    $this->cache->put(
                        $key,
                        $ips,
                        1440
                    );
                }
            } catch (Exception $e) {}
        } else {
            $ips = $this->cache->get($key);
        }

        return $ips;
    }
}
