<?php

namespace Bausch\Models;

use Eloquent;

class OptInDomain extends Eloquent {

    use OptDomain;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'optin_domain';

}
