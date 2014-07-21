<?php

namespace Bausch\Repositories;

use Bausch\Models\DomainAwl;

class DomainAwlRepositoryEloquent implements DomainAwlRepositoryInterface {

    public function findAll() {
        $data = DomainAwl::orderBy('sender_domain', 'asc')->get();

        return $data;
    }

}
