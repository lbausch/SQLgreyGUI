<?php

namespace Bausch\Models;

use Eloquent;

class OptOutEmail extends Eloquent {

    use OptEmail;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'optout_email';

}
