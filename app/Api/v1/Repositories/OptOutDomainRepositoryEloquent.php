<?php

namespace SQLgreyGUI\Api\v1\Repositories;

class OptOutDomainRepositoryEloquent extends BaseRepositoryEloquent implements OptOutDomainRepositoryInterface
{
    use OptDomainTrait;

    /**
     * Model class.
     *
     * @var string
     */
    protected $model_class = 'OptOutDomain';
}
