<?php

namespace Bausch\Repositories;

use Bausch\Models\Connect;

class ConnectRepositoryEloquent implements ConnectRepositoryInterface {

    public function findAll() {
        $data = Connect::orderBy('first_seen', 'desc')->get();

        return $data;
    }

}
