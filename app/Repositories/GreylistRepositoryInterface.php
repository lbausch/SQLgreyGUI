<?php

namespace SQLgreyGUI\Repositories;

use Carbon\Carbon;

interface GreylistRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * If $end is omitted, the current timestamp is used.
     *
     * @param Carbon      $start
     * @param Carbon|null $end
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findBetween(Carbon $start, Carbon $end = null);

    /**
     * Destroy entries older than given date.
     *
     * @param Carbon $date
     *
     * @return bool
     */
    public function destroyOlderThan(Carbon $date);
}
