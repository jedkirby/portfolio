<?php

namespace App\Domain\Project\Repository;

use App\Domain\Common\Repository\AbstractStaticRepository;
use App\Domain\Project\Entity\Post;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * @codeCoverageIgnore
 */
class PostRepository extends AbstractStaticRepository
{
    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        foreach ($config->get('project.posts', []) as $id => $article) {
            $this->entities[$id] = new Post(
                $id,
                $article['title'],
                $article['subtitle'],
                $article['icon'],
                $article['date'],
                $article['introduction'],
                $article['content'],
                $article['testimonial'],
                $article['link'],
                $article['expired'],
                $article['hero'],
                $article['keywords'],
                $article['images']
            );
        }
    }
}
