<?php

namespace SQLgreyGUI\Repositories;

class OptInEmailRepositoryEloquent implements OptInEmailRepositoryInterface {

    use OptEmailTrait;

    protected $model = 'OptInEmail';

}
