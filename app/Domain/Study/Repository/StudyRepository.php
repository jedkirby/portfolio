<?php

namespace App\Domain\Study\Repository;

use App\Domain\Common\Repository\AbstractStaticRepository;
use App\Domain\Study\Entity\Item;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * @codeCoverageIgnore
 */
class StudyRepository extends AbstractStaticRepository
{
    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        foreach ($config->get('content.studies', []) as $id => $article) {
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
