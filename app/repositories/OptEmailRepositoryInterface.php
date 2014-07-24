<?php

namespace Bausch\Repositories;

interface OptEmailRepositoryInterface extends BaseRepositoryInterface {

    /**
     * destroy email
     * 
     * @param Email $email
     */
    public function destroy($email);

    /**
     * store email
     * 
     * @param Email $email
     */
    public function store($email);
}
