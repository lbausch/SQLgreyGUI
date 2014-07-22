<?php

namespace Bausch\Repositories;

trait OptEmailTrait {

    public function findAll() {
        $model = 'Bausch\Models\\' . $this->model;

        $model = new $model;

        $data = $model::orderBy('email', 'asc')->get();

        return $data;
    }

}
