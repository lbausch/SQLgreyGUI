<?php

namespace Bausch\Models;

class OptOutEmail extends SQLgreyConnection {

    use OptEmail;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'optout_email';

}
