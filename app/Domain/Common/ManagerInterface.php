<?php

namespace App\Domain\Common;

interface ManagerInterface
{
    /**
     * @return array
     */
    public function getAll();

    /**
     * @param int $limit
     *
     * @return array
     */
    public function getLimit($limit);

    /**
     * @param string $id
     *
     * @throws App\Domain\Common\Exception\EntityNotFoundException
     *
     * @return Entity
     */
    public function getById($id);

    /**
     * @return int
     */
    public function getCount();
}
