<?php

namespace Bausch\Models;

class OptInDomain extends SQLgreyConnection {

    use OptDomain;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'optin_domain';

}
