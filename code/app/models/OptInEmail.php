<?php

namespace Bausch\Models;

class OptInEmail extends SQLgreyConnection {

    use OptEmail;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'optin_email';

}
