<?php

namespace SQLgreyGUI\Repositories;

use SQLgreyGUI\Models\AwlDomain as Domain;

interface AwlDomainRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * store 
     * 
     * @param \Bausch\Models\AwlDomain $domain
     */
    public function store(Domain $domain);

    /**
     * destroy domains
     * 
     * @param \Bausch\Models\AwlDomain $domain
     */
    public function destroy(Domain $domain);
}
