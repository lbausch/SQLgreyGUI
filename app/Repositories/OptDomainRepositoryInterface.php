<?php

namespace SQLgreyGUI\Repositories;


interface OptDomainRepositoryInterface extends BaseRepositoryInterface {

    /**
     * destroy domain
     * 
     * @param Domain $domain
     */
    public function destroy($domain);

    /**
     * store domain
     * 
     * @param Domain $domain
     */
    public function store($domain);
}
