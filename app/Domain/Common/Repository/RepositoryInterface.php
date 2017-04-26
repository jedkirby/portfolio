<?php

namespace App\Domain\Common\Repository;

use App\Domain\Common\Entity\EntityInterface;
use App\Domain\Common\Entity\Exception\EntityNotFoundException;

interface RepositoryInterface
{
    /**
     * @return EntityInterface[]
     */
    public function getAll();

    /**
     * @param int $limit
     *
     * @return EntityInterface[]
     */
    public function getLimit($limit);

    /**
     * @return EntityInterface
     */
    public function getFirst();

    /**
     * @return EntityInterface
     */
    public function getLast();

    /**
     * @param string $id
     *
     * @throws EntityNotFoundException
     *
     * @return EntityInterface
     */
    public function getById($id);

    /**
     * @param array $ids
     *
     * @return EntityInterface[]
     */
    public function getByIds(array $ids);

    /**
     * @return int
     */
    public function getCount();
}
