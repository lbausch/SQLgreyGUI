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
     * Get sender domain.
     *
     * @return string
     */
    public function getSenderDomain()
    {
        return $this->sender_domain;
    }

    /**
     * Set sender_domain.
     *
     * @param $sender_domain
     */
    public function setSenderDomain($sender_domain)
    {
        $this->sender_domain = $sender_domain;
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
     * Set source.
     *
     * @param $source
     */
    public function setSource($source)
    {
        $this->source = $source;
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
     * Set first_seen.
     *
     * @param $first_seen
     */
    public function setFirstSeen($first_seen)
    {
        $this->first_seen = $first_seen;
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

    /**
     * Set last_seen.
     *
     * @param $last_seen
     */
    public function setLastSeen($last_seen)
    {
        $this->last_seen = $last_seen;
    }
}
