<?php

namespace Bausch\Repositories;

use Bausch\Models\Greylist;
use Carbon\Carbon;

class GreylistRepositoryEloquent implements GreylistRepositoryInterface {

    public function findAll() {
        $data = Greylist::orderBy('first_seen', 'desc')->get();

        return $data;
    }

    public function findByPeriod($period = null) {
        if (is_null($period)) {
            $period = '30d';
        }

        $period = trim($period);

        $period_unit = substr($period, -1);
        $period_number = substr($period, 0, -1);

        $now = Carbon::now();

        switch ($period_unit) {
            case 'd':
            default:
                $period_start = $now->subDays($period_number)->startOfDay();
                break;
        }

        $period_start = $period_start->toDateTimeString();

        $data = Greylist::where('first_seen', '>=', $period_start)->get();

        return $data;
    }

}
