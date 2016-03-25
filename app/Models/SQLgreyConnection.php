<?php

namespace SQLgreyGUI\Models;

use Illuminate\Database\Eloquent\Model;

class SQLgreyConnection extends Model
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_SQLGREY', 'mysql_sqlgrey');
    }
}
