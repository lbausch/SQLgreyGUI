<?php

namespace Bausch\Repositories;

use Bausch\Models\AwlEmail as Email;

interface AwlEmailRepositoryInterface extends BaseRepositoryInterface {

    /**
     * store 
     * 
     * @param \Bausch\Models\AwlEmail $email
     */
    public function store(Email $email);

    /**
     * destroy
     * 
     * @param \Bausch\Models\AwlEmail $email
     */
    public function destroy(Email $email);
}
