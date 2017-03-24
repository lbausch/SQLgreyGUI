<?php

namespace SQLgreyGUI\Api\v1\Repositories;

interface AwlDomainRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find by domain and source.
     *
     * @param string $domain
     * @param string $source
     *
     * @return \SQLgreyGUI\Models\AwlEmail
     */
    public function findByDomainSource($domain, $source);
}
