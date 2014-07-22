<?php

namespace Bausch\Repositories;

use Bausch\Models\User;

class UserRepositoryEloquent implements UserRepositoryInterface {

    public function findAll() {
        $data = User::all()->get();

        return $data;
    }

    public function instance($data = array()) {
        return new User($data);
    }

    public function store(User $user) {
        return $user->save();
    }

}
