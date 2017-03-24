<?php

namespace SQLgreyGUI\Api\v1\Repositories;

interface BaseRepositoryInterface extends \Bausch\LaravelCornerstone\Repositories\BaseRepositoryInterface
{
    /**
     * Find all.
     */
    public function findAll();
}
