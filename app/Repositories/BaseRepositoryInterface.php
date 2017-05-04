<?php

namespace SQLgreyGUI\Repositories;

interface BaseRepositoryInterface extends \Bausch\LaravelCornerstone\Repositories\BaseRepositoryInterface
{
    /**
     * Find all.
     */
    public function findAll();

    public function findBy(array $criteria);
}
