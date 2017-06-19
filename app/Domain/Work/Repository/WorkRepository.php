<?php

namespace App\Domain\Work\Repository;

use App\Domain\Common\Repository\AbstractStaticRepository;
use App\Domain\Work\Entity\Item;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * @codeCoverageIgnore
 */
class WorkRepository extends AbstractStaticRepository
{
    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        foreach ($config->get('content.work', []) as $id => $article) {
            $this->entities[$id] = new Item(
                $id,
                $article['title'],
                $article['date'],
                $article['intro'],
                $article['hero']
            );
        }
    }
}
