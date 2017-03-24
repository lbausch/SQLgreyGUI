<?php

namespace SQLgreyGUI\Api\v1\Repositories;

class OptInEmailRepositoryEloquent extends BaseRepositoryEloquent implements OptInEmailRepositoryInterface
{
    use OptEmailTrait;

    /**
     * Model class.
     *
     * @var string
     */
    protected $model_class = 'OptInEmail';
}
