<?php

namespace SQLgreyGUI\Repositories;

trait OptDomainTrait
{
    public function __construct()
    {
        $this->model = app('SQLgreyGUI\Models\\'.$this->model_class);
    }

    public function findAll()
    {
        $data = $this->model->orderBy('domain', 'asc')->get();

        return $data;
    }

    public function destroy($domain)
    {
        return $this->model->where('domain', $domain->getDomain())->delete();
    }

    public function store($domain)
    {
        return $this->model->insert([
            'domain' => $domain->getDomain(),
        ]);
    }
}
