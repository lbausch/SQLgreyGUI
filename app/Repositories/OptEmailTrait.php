<?php

namespace SQLgreyGUI\Repositories;

trait OptEmailTrait
{
    public function __construct()
    {
        $this->model = app('SQLgreyGUI\Models\\'.$this->model_class);
    }

    public function findAll()
    {
        $data = $this->model->orderBy('email', 'asc')->get();

        return $data;
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)
            ->get()
            ->first();
    }

    public function destroy($email)
    {
        return $this->model->where('email', $email->getEmail())->delete();
    }

    public function store($email)
    {
        return $this->model->insert([
            'email' => $email->getEmail(),
        ]);
    }
}
