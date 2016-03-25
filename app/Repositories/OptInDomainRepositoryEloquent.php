<?php

namespace SQLgreyGUI\Repositories;

class OptInDomainRepositoryEloquent extends BaseRepositoryEloquent implements OptInDomainRepositoryInterface
{
    use OptDomainTrait;

    /**
     * Model class.
     *
     * @var string
     */
    protected $model_class = 'OptInDomain';
}
