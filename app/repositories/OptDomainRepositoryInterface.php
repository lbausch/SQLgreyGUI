<?php

namespace Bausch\Repositories;

interface OptDomainRepositoryInterface extends BaseRepositoryInterface {

    /**
     * destroy domain
     * 
     * @param Domain $domain
     */
    public function destroy($domain);
}
