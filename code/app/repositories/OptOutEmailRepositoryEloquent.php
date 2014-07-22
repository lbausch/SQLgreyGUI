<?php

namespace Bausch\Repositories;

class OptOutEmailRepositoryEloquent implements OptOutEmailRepositoryInterface {

    use OptEmailTrait;
    
    protected $model = 'OptOutEmail';

}
