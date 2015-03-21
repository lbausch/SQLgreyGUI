<?php

namespace SQLgreyGUI\Repositories;

class OptInDomainRepositoryEloquent implements OptInDomainRepositoryInterface {

    use OptDomainTrait;
    
    protected $model = 'OptInDomain';

}
