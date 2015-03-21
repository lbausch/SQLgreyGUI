<?php

namespace SQLgreyGUI\Repositories;

class OptOutEmailRepositoryEloquent implements OptOutEmailRepositoryInterface {

    use OptEmailTrait;
    
    protected $model = 'OptOutEmail';

}
