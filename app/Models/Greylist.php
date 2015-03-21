<?php

namespace SQLgreyGUI\Models;

class Greylist extends SQLgreyConnection
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'connect';

    /**
     * mass assignment: guarded attributes
     * 
     * @var array 
     */
    protected $guarded = array();

    /**
     * get sender name
     * 
     * @return string
     */
    public function getSenderName()
    {
        return $this->sender_name;
    }

    /**
     * get sender domain
     * 
     * @return string
     */
    public function getSenderDomain()
    {
        return $this->sender_domain;
    }

    /**
     * get source
     * 
     * @return string
     */
    public function getSource()
    {
        return $this->src;
    }

    /**
     * get recipient
     * 
     * @return string
     */
    public function getRecipient()
    {
        return $this->rcpt;
    }

    /**
     * get first seen
     * 
     * @return string
     */
    public function getFirstSeen()
    {
        return $this->first_seen;
    }

}
