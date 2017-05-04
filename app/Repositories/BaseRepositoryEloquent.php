<?php

namespace SQLgreyGUI\Repositories;

abstract class BaseRepositoryEloquent extends \Bausch\LaravelCornerstone\Repositories\EloquentAbstractRepository implements BaseRepositoryInterface
{
    public function findAll()
    {
        $data = $this->model->all();

        return $data;
    }

    /**
     * Find by.
     *
     * @param array $criteria
     *
     * @return \SQLgreyGUI\Models\Greylist
     */
    public function findBy(array $criteria)
    {
        return $this->model->where($criteria)->get();
    }
}
