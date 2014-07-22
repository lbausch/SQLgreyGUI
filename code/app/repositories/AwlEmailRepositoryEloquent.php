<?php

namespace Bausch\Repositories;

use Bausch\Models\AwlEmail as Email;

class AwlEmailRepositoryEloquent implements AwlEmailRepositoryInterface {

    public function findAll() {
        $data = Email::orderBy('sender_name', 'asc')->get();
        
        return $data;
    }

}
