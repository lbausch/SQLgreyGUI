<?php

namespace Bausch\Repositories;

use Bausch\Models\AwlEmail;

interface AwlEmailRepositoryInterface extends BaseRepositoryInterface {

    /**
     * store 
     * 
     * @param \Bausch\Models\AwlEmail $email
     */
    public function store(AwlEmail $email);
}
