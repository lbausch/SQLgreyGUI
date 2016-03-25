<?php

namespace SQLgreyGUI\Models;

class OptDomain extends SQLgreyConnection
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain',
    ];

    /**
     * validation rules.
     *
     * @var array
     */
    public $rules = [
        'domain' => 'required',
    ];

    /**
     * Get domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
