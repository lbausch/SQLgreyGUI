<?php

namespace Bausch\Repositories;

use Bausch\Models\AwlDomain as Domain;

class AwlDomainRepositoryEloquent implements AwlDomainRepositoryInterface {

    public function findAll() {
        $data = Domain::orderBy('sender_domain', 'asc')->get();

        return $data;
    }

}
