<?php

namespace SQLgreyGUI\Repositories;

interface OptEmailRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find by Email.
     *
     * @param string $email
     *
     * @return mixed
     */
    public function findByEmail($email);
}
