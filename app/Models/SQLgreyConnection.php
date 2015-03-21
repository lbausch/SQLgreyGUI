<?php

namespace SQLgreyGUI\Models;

use Illuminate\Database\Eloquent\Model;

class SQLgreyConnection extends Model
{

    /**
     * the database connection used
     * 
     * @var string
     */
    protected $connection = 'sqlgrey';

    /**
     * guarded attributes
     * 
     * @var array
     */
    protected $guarded = array();

}
