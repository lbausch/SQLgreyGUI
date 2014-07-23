<?php

namespace Bausch\Repositories;

trait OptDomainTrait {

    private $model_class;

    /**
     * Constructor
     */
    public function __construct() {
        $this->model_class = 'Bausch\Models\\' . $this->model;
    }

    public function findAll() {
        $this->model_class = 'Bausch\Models\\' . $this->model;

        $data = new $this->model_class;

        $data = $data::orderBy('domain', 'asc')->get();

        return $data;
    }

    public function instance($data = array()) {
        $model = $this->model_class;

        return new $model($data);
    }

    public function destroy($domain) {
        $model = $this->model_class;

        return $model::where('domain', $domain->getDomain())->delete();
    }

}
