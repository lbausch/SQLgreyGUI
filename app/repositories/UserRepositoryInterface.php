<?php

namespace Bausch\Repositories;

use Bausch\Models\User as User;

interface UserRepositoryInterface extends BaseRepositoryInterface {

    /**
     * find a user by his id
     * 
     * @param int $id
     * 
     * @return User
     */
    public function findById($id);

    /**
     * store a user
     * 
     * @param \Bausch\Models\User $user
     */
    public function store(User $user);

    /**
     * update user
     * 
     * @param \Bausch\Models\User $user
     */
    public function update(User $user);

    /**
     * destroy user
     * 
     * @param \Bausch\Models\User $user
     */
    public function destroy(User $user);
}
