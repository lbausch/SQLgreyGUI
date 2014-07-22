<?php

namespace Bausch\Models;

use Eloquent;

class OptOutDomain extends Eloquent {

    use OptDomain;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'optout_domain';

}
