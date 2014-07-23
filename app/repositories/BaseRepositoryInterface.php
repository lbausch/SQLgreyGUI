<?php

namespace Bausch\Repositories;

interface BaseRepositoryInterface {

    /**
     * find all
     */
    public function findAll();

    /**
     * create instance
     * 
     * @param array $data
     */
    public function instance($data = array());
}
