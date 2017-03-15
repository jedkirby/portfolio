<?php

namespace App\Domain\Project;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Common\ManagerInterface;
use App\Domain\Project\Entity\Post;
use Illuminate\Contracts\Config\Repository as Config;

class ProjectManager implements ManagerInterface
{
    /**
     * @var Post[]
     */
    private $posts = [];

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        foreach ($config->get('project.posts', []) as $id => $article) {
            $this->posts[$id] = new Post(
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

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->posts;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit($limit)
    {
        return array_slice($this->posts, 0, $limit);
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        if (!array_key_exists($id, $this->posts)) {
            throw new EntityNotFoundException();
        }

        return $this->posts[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return count($this->posts);
    }
}
