<?php

namespace SQLgreyGUI\Repositories;

interface AwlEmailRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find by name, domain and source.
     *
     * @param string $name
     * @param string $domain
     * @param string $source
     *
     * @return \SQLgreyGUI\Models\AwlEmail
     */
    public function findByNameDomainSource($name, $domain, $source);

    /**
     * Find -undef- records.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findUndef();
}
