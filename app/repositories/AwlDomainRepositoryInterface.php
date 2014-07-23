<?php

namespace Bausch\Repositories;

use \Bausch\Models\AwlDomain as Domain;

interface AwlDomainRepositoryInterface extends BaseRepositoryInterface {

    /**
     * destroy domains
     * 
     * @param \Bausch\Models\AwlDomain $domain
     */
    public function destroy(Domain $domain);
}
