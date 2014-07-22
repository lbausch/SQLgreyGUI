<?php

namespace Bausch\Repositories;

trait OptEmailTrait {

    private $model_class;

    public function findAll() {
        $this->model_class = 'Bausch\Models\\' . $this->model;

        $model = new $this->model_class;

        $data = $model::orderBy('email', 'asc')->get();

        return $data;
    }

    public function instance($data = array()) {
        $model = $this->model_class;

        return $model::create($data);
    }

}
