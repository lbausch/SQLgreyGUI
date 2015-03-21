<?php

namespace SQLgreyGUI\Repositories;

class OptOutDomainRepositoryEloquent implements OptOutDomainRepositoryInterface {

    use OptDomainTrait;

    protected $model = 'OptOutDomain';

}
