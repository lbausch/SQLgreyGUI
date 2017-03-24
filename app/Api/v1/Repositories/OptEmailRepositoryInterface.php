<?php

namespace SQLgreyGUI\Api\v1\Repositories;

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
