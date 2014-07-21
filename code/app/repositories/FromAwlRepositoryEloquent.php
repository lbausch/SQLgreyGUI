<?php

namespace Bausch\Repositories;

use Bausch\Models\FromAwl;

class FromAwlRepositoryEloquent implements FromAwlRepositoryInterface {

    public function findAll() {
        $data = FromAwl::orderBy('sender_name', 'asc')->get();
        
        return $data;
    }

}
