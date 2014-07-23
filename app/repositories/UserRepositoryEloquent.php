<?php

namespace Bausch\Repositories;

use Bausch\Models\User;

class UserRepositoryEloquent implements UserRepositoryInterface {

    public function findById($id) {
        $data = User::where('id', $id);

        if ($data->count() > 0) {
            return $data->first();
        }
    }

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

    public function update(User $user) {
        return $user->save();
    }

}
