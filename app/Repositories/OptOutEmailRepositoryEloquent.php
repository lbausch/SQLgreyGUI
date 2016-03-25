<?php

namespace SQLgreyGUI\Repositories;

class OptOutEmailRepositoryEloquent extends BaseRepositoryEloquent implements OptOutEmailRepositoryInterface
{
    use OptEmailTrait;

    /**
     * Model class.
     *
     * @var string
     */
    protected $model_class = 'OptOutEmail';
}
