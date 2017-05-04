<?php

namespace SQLgreyGUI\Repositories;

use Carbon\Carbon;
use SQLgreyGUI\Models\Greylist;

class GreylistRepositoryEloquent extends BaseRepositoryEloquent implements GreylistRepositoryInterface
{
    public function __construct(Greylist $greylist)
    {
        $this->model = $greylist;
    }

    public function findAll()
    {
        $data = $this->model->orderBy('first_seen', 'desc')->get();

        return $data;
    }

    public function findBetween(Carbon $start, Carbon $end = null)
    {
        if (is_null($end)) {
            $end = Carbon::now();
        }

        $data = $this->model->where('first_seen', '>=', $start->toDateTimeString())
            ->where('first_seen', '<=', $end->toDateTimeString())
            ->get();

        return $data;
    }

    public function findUndef()
    {
        return $this->model->where([
            'sender_name' => '-undef-',
            'sender_domain' => '-undef-',
        ])->get();
    }

    public function destroy($greylist)
    {
        return $this->model->where('sender_name', $greylist->getSenderName())
            ->where('sender_domain', $greylist->getSenderDomain())
            ->where('src', $greylist->getSource())
            ->where('rcpt', $greylist->getRecipient())
            ->delete();
    }

    public function destroyOlderThan(Carbon $date)
    {
        return $this->model->where('first_seen', '<=', $date->toDateTimeString())
            ->delete();
    }
}
