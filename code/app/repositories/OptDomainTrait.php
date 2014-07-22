<?php

namespace Bausch\Repositories;

trait OptDomainTrait {

    public function findAll() {
        $model = 'Bausch\Models\\' . $this->model;

        $data = new $model;

        $data = $data::orderBy('domain', 'asc')->get();

        return $data;
    }

}
