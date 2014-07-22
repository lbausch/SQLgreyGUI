<?php

namespace Bausch\Repositories;

class OptInEmailRepositoryEloquent implements OptInEmailRepositoryInterface {

    use OptEmailTrait;

    protected $model = 'OptInEmail';

}
