<?php

namespace SQLgreyGUI\Repositories;

use SQLgreyGUI\Models\AwlDomain as Domain;

class AwlDomainRepositoryEloquent implements AwlDomainRepositoryInterface
{

    public function findAll()
    {
        $data = Domain::orderBy('sender_domain', 'asc')->get();

        return $data;
    }

    public function instance($data = array())
    {
        return new Domain($data);
    }

    public function store(Domain $domain)
    {
        return Domain::insert(array(
                    'sender_domain' => $domain->getSenderDomain(),
                    'src' => $domain->getSource(),
                    'first_seen' => $domain->getFirstSeen(),
                    'last_seen' => $domain->getLastSeen(),
        ));
    }

    public function destroy(Domain $domain)
    {
        return Domain::where('sender_domain', $domain->getSenderDomain())
                        ->where('src', $domain->getSource())
                        ->delete();
    }

}
