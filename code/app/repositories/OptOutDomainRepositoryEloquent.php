<?php

namespace Bausch\Repositories;

class OptOutDomainRepositoryEloquent implements OptOutDomainRepositoryInterface {

    use OptDomainTrait;

    protected $model = 'OptOutDomain';

}
