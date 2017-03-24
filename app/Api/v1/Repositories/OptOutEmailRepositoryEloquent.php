<?php

namespace SQLgreyGUI\Api\v1\Repositories;

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
