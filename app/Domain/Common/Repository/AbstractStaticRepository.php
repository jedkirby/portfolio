<?php

namespace App\Domain\Common\Repository;

use App\Domain\Common\Entity\EntityInterface;
use App\Domain\Common\Exception\EntityNotFoundException;

abstract class AbstractStaticRepository implements RepositoryInterface
{
    /**
     * @var EntityInterface[]
     */
    protected $entities = [];

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->entities;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit($limit)
    {
        return array_slice($this->entities, 0, $limit);
    }

    /**
     * {@inheritdoc}
     */
    public function getFirst()
    {
        return reset($this->entities);
    }

    /**
     * {@inheritdoc}
     */
    public function getLast()
    {
        return end($this->entities);
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        if (!array_key_exists($id, $this->entities)) {
            throw new EntityNotFoundException(sprintf('Unable to find entity "%s"', $id));
        }

        return $this->entities[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function getByIds(array $ids)
    {
        $entities = [];
        foreach ($ids as $id) {
            $entities[$id] = $this->getById($id);
        }

        return $entities;
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return count($this->entities);
    }
}
