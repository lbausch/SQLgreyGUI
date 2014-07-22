<?php

namespace Bausch\Repositories;

trait OptEmailTrait {

    public function findAll() {
        $model = 'Bausch\Models\\' . $this->model;

        $data = new $model;

        $data = $data::orderBy('email', 'asc')->get();

        return $data;
    }

}
