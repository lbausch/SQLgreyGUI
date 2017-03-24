<?php

namespace SQLgreyGUI\Api\v1\Repositories;

use SQLgreyGUI\Models\User as User;

class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
