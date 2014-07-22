<?php

namespace Bausch\Repositories;

interface GreylistRepositoryInterface extends BaseRepositoryInterface {

    /**
     * find entries for given period of time
     * 
     * @param string $period
     */
    public function findByPeriod($period = null);
}
