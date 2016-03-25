<?php

namespace SQLgreyGUI\Repositories;

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
