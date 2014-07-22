<?php

namespace Bausch\Models;

use Eloquent;

class OptInEmail extends Eloquent {

    use OptEmail;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'optin_email';

}
