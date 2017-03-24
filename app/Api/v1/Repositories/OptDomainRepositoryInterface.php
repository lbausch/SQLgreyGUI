<?php

namespace SQLgreyGUI\Api\v1\Repositories;

interface OptDomainRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find by Domain.
     *
     * @param string $domain
     *
     * @return mixed
     */
    public function findByDomain($domain);
}
