<?php

namespace Bausch\Models;

class OptOutDomain extends SQLgreyConnection {

    use OptDomain;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'optout_domain';

}
