<?php

namespace SQLgreyGUI\Repositories;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Container\Container;

class UserProviderEloquent extends EloquentUserProvider implements UserProviderInterface
{
    public function __construct()
    {
        $model = config('auth.providers.sqlgreygui.model');
        $hasher = Container::getInstance()->make('hash');

        parent::__construct($hasher, $model);
    }
}
