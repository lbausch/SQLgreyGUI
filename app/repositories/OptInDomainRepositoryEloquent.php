<?php

namespace Bausch\Repositories;

class OptInDomainRepositoryEloquent implements OptInDomainRepositoryInterface {

    use OptDomainTrait;
    
    protected $model = 'OptInDomain';

}
