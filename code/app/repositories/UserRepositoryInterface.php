<?php

namespace Bausch\Repositories;

use Bausch\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface {

    public function store(User $user);
}
