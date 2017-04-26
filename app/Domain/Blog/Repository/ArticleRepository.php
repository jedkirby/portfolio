<?php

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Entity\Article;
use App\Domain\Common\Repository\AbstractStaticRepository;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * @codeCoverageIgnore
 */
class ArticleRepository extends AbstractStaticRepository
{
    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        foreach ($config->get('blog.articles', []) as $id => $article) {
            $this->entities[$id] = new Article(
                $id,
                $article['title'],
                $article['date'],
                $article['snippet'],
                $article['content'],
                $article['image'],
                $article['keywords']
            );
        }
    }
}
