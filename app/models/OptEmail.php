<?php

namespace Bausch\Models;

class OptEmail extends SQLgreyConnection {

    /**
     * fillable attributes
     * 
     * @var array
     */
    protected $fillable = array(
        'email',
    );

    /**
     * validation rules
     * 
     * @var array
     */
    public $rules = array(
        'email' => 'required',
    );

    /**
     * get email
     * 
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

}
