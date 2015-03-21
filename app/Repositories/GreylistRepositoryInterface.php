<?php

namespace SQLgreyGUI\Repositories;

use SQLgreyGUI\Models\Greylist;

interface GreylistRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * find entries for given period of time
     * 
     * @param string $period
     */
    public function findByPeriod($period = null);

    /**
     * if $end is omitted, the current timestamp is used
     * 
     * @param int $start
     * @param int $end
     */
    public function findBetween($start, $end = null);

    /**
     * delete
     * 
     * @param Greylist $greylist
     * 
     * @return bool
     */
    public function destroy(Greylist $greylist);
}
