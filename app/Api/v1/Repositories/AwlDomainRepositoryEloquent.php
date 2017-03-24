<?php

namespace SQLgreyGUI\Api\v1\Repositories;

use SQLgreyGUI\Models\AwlDomain as Domain;

class AwlDomainRepositoryEloquent extends BaseRepositoryEloquent implements AwlDomainRepositoryInterface
{
    public function __construct(Domain $domain)
    {
        $this->model = $domain;
    }

    public function findAll()
    {
        $data = $this->model->orderBy('sender_domain', 'asc')->get();

        return $data;
    }

    public function findByDomainSource($domain, $source)
    {
        $domain = $this->model->where('sender_domain', $domain)
            ->where('src', $source)
            ->get()
            ->first();

        return $domain;
    }

    public function store($domain)
    {
        return $this->model->insert(array(
            'sender_domain' => $domain->getSenderDomain(),
            'src' => $domain->getSource(),
            'first_seen' => $domain->getFirstSeen(),
            'last_seen' => $domain->getLastSeen(),
        ));
    }

    public function destroy($domain)
    {
        return $this->model->where('sender_domain', $domain->getSenderDomain())
            ->where('src', $domain->getSource())
            ->delete();
    }
}
