<?php

namespace Bausch\Repositories;

use \Bausch\Models\Greylist;

interface GreylistRepositoryInterface extends BaseRepositoryInterface {

    /**
     * find entries for given period of time
     * 
     * @param string $period
     */
    public function findByPeriod($period = null);

    /**
     * delete
     * 
     * @param Greylist $greylist
     * 
     * @return bool
     */
    public function destroy(Greylist $greylist);
}
