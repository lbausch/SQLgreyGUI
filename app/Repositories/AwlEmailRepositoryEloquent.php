<?php

namespace SQLgreyGUI\Repositories;

use SQLgreyGUI\Models\AwlEmail as Email;

class AwlEmailRepositoryEloquent extends BaseRepositoryEloquent implements AwlEmailRepositoryInterface
{
    public function __construct(Email $email)
    {
        $this->model = $email;
    }

    public function findAll()
    {
        $data = $this->model->orderBy('sender_name', 'asc')->get();

        return $data;
    }

    public function findByNameDomainSource($name, $domain, $source)
    {
        $email = $this->model->where('sender_name', $name)
            ->where('sender_domain', $domain)
            ->where('src', $source)
            ->get()
            ->first();

        return $email;
    }

    public function findUndef()
    {
        return $this->model->where([
            'sender_name' => '-undef-',
            'sender_domain' => '-undef-',
        ])->get();
    }

    public function store($email)
    {
        return $this->model->insert(array(
            'sender_name' => $email->getSenderName(),
            'sender_domain' => $email->getSenderDomain(),
            'src' => $email->getSource(),
            'first_seen' => $email->getFirstSeen(),
            'last_seen' => $email->getLastSeen(),
        ));
    }

    public function destroy($email)
    {
        return $this->model->where('sender_name', $email->getSenderName())
            ->where('sender_domain', $email->getSenderDomain())
            ->where('src', $email->getSource())
            ->delete();
    }
}
