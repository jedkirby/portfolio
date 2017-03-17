<?php

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Entity\Article;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Common\Repository\RepositoryInterface;
use Illuminate\Contracts\Config\Repository as Config;

class ArticleRepository implements RepositoryInterface
{
    /**
     * @var Article[]
     */
    private $articles = [];

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        foreach ($config->get('blog.articles', []) as $id => $article) {
            $this->articles[$id] = new Article(
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

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->articles;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit($limit)
    {
        return array_slice($this->articles, 0, $limit);
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        if (!array_key_exists($id, $this->articles)) {
            throw new EntityNotFoundException();
        }

        return $this->articles[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return count($this->articles);
    }
}
