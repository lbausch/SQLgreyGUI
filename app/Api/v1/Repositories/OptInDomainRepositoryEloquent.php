<?php

namespace SQLgreyGUI\Api\v1\Repositories;

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
