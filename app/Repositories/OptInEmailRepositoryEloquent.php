<?php

namespace SQLgreyGUI\Repositories;

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
