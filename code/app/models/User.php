<?php

namespace Bausch\Models;

use Eloquent;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Hash;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    /**
     * get id
     * 
     * @return int
     */
    public function getId() {
        return intval($this->id);
    }
    
    /**
     * get username
     * 
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * get password
     * 
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * get email
     * 
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * is enabled
     * 
     * @return bool
     */
    public function isEnabled() {
        return ($this->enabled === true) ? true : false;
    }

    /**
     * set username
     * 
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * set password
     * 
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = Hash::make($password);
    }

    /**
     * set email
     * 
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * set enabled
     * 
     * @param bool $enabled
     */
    public function setEnabled($enabled) {
        if ($enabled === true) {
            $this->enabled = true;
        } else {
            $this->enabled = false;
        }
    }

}
