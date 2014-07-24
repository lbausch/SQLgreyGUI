<?php

namespace Bausch\Models;

class OptDomain extends SQLgreyConnection {

    /**
     * fillable attributes
     * 
     * @var array
     */
    protected $fillable = array(
        'domain',
    );

    /**
     * validation rules
     * 
     * @var array
     */
    public $rules = array(
        'domain' => 'required',
    );

    /**
     * get domain
     * 
     * @return string
     */
    public function getDomain() {
        return $this->domain;
    }

}
