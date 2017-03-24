<?php

namespace SQLgreyGUI\Api\v1\Repositories;

abstract class BaseRepositoryEloquent extends \Bausch\LaravelCornerstone\Repositories\EloquentAbstractRepository
{
    public function findAll()
    {
        $data = $this->model->all();

        return $data;
    }
}
