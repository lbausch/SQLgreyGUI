<?php

namespace SQLgreyGUI\Models;

use Illuminate\Database\Eloquent\Model;

abstract class SQLgreyConnection extends Model
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = config('sqlgreygui.connection');
    }
}
