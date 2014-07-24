<?php

namespace Bausch\Repositories;

trait OptEmailTrait {

    private $model_class;

    /**
     * Constructor
     */
    public function __construct() {
        $this->model_class = 'Bausch\Models\\' . $this->model;
    }

    public function findAll() {
        $model = new $this->model_class;

        $data = $model::orderBy('email', 'asc')->get();

        return $data;
    }

    public function instance($data = array()) {
        $model = $this->model_class;

        return new $model($data);
    }

    public function destroy($email) {
        $model = $this->model_class;

        return $model::where('email', $email->getEmail())->delete();
    }

    public function store($email) {
        $model = $this->model_class;

        return $model::insert(array(
                    'email' => $email->getEmail(),
        ));
    }

}
