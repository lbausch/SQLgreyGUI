<?php

namespace SQLgreyGUI\Repositories;

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
