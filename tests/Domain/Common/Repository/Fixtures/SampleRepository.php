<?php

namespace App\Tests\Domain\Common\Repository\Fixtures;

use App\Domain\Common\Repository\AbstractStaticRepository;
use Illuminate\Contracts\Config\Repository as Config;

class SampleRepository extends AbstractStaticRepository
{
    public function __construct(Config $config)
    {
        foreach ($config->get('sample.entities', []) as $id => $article) {
            $this->entities[$id] = new SampleEntity(
                $id,
                $article['title']
            );
        }
    }
}
