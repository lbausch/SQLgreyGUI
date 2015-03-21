<?php

namespace SQLgreyGUI\Repositories;

use SQLgreyGUI\Models\Greylist;
use Carbon\Carbon;

class GreylistRepositoryEloquent implements GreylistRepositoryInterface
{

    public function findAll()
    {
        $data = Greylist::orderBy('first_seen', 'desc')->get();

        return $data;
    }

    public function findBetween($start, $end = null)
    {
        $start = Carbon::createFromTimestamp($start);

        if (is_null($end)) {
            $end = new Carbon($end);
        } else {
            $end = Carbon::createFromTimestamp($end);
        }

        $data = Greylist::where('first_seen', '>=', $start->toDateTimeString())
                ->where('first_seen', '<=', $end->toDateTimeString())
                ->get();

        return $data;
    }

    public function findByPeriod($period = null)
    {
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

    public function instance($data = array())
    {
        return new Greylist($data);
    }

    public function destroy(Greylist $greylist)
    {
        return Greylist::where('sender_name', $greylist->getSenderName())
                        ->where('sender_domain', $greylist->getSenderDomain())
                        ->where('src', $greylist->getSource())
                        ->where('rcpt', $greylist->getRecipient())
                        ->delete();
    }

}
