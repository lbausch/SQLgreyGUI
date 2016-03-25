<?php

namespace SQLgreyGUI\Models;

use Carbon\Carbon;

class AwlDomain extends SQLgreyConnection
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'domain_awl';

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
        'sender_domain',
        'src',
        'first_seen',
        'last_seen',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'first_seen',
        'last_seen',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'sender_domain' => 'required',
        'src' => 'required',
    ];

    /**
     * Get sender domain.
     *
     * @return string
     */
    public function getSenderDomain()
    {
        return $this->sender_domain;
    }

    /**
     * Get source.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->src;
    }

    /**
     * Get first seen.
     *
     * @return Carbon|null
     */
    public function getFirstSeen()
    {
        return $this->first_seen;
    }

    /**
     * Get last seen.
     *
     * @return Carbon|null
     */
    public function getLastSeen()
    {
        return $this->last_seen;
    }
}
