<?php

namespace Bausch\Models;

use Eloquent;

class SQLgreyConnection extends Eloquent {

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
