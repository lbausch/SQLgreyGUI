<?php

namespace Bausch\Repositories;

trait OptDomainTrait {

    private $model_class;

    public function findAll() {
        $this->model_class = 'Bausch\Models\\' . $this->model;

        $data = new $this->model_class;

        $data = $data::orderBy('domain', 'asc')->get();

        return $data;
    }

    public function instance($data = array()) {
        $model = $this->model_class;

        return $model::create($data);
    }

}
