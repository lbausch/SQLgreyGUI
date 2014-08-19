<?php

namespace Bausch\Models;

use Eloquent;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Hash;
use Carbon\Carbon;

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
     * mass assignment: fillable attributes
     * 
     * @var array
     */
    protected $fillable = array(
        'username',
        'email',
        'enabled'
    );

    /**
     * validation rules
     * 
     * @var array 
     */
    public static $rules = array(
        'store' => array(
            'username' => 'required|unique:users,username',
            'email' => 'required',
            'enabled' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required_with:password',
        ),
        'update' => array(
            'username' => 'required|unique:users,username,', // id is appended dynamically
            'email' => 'required',
            'enabled' => 'required',
            'password' => 'sometimes|required|confirmed',
            'password_confirmation' => 'sometimes|required_with:password',
        ),
    );

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
     * get updated at
     * 
     * @return \Carbon\Carbon
     */
    public function getUpdatedAt() {
        return new Carbon($this->updated_at);
    }

    /**
     * get created at
     * 
     * @return \Carbon\Carbon
     */
    public function getCreatedAt() {
        return new Carbon($this->created_at);
    }

    /**
     * is enabled
     * 
     * @return bool
     */
    public function isEnabled() {
        return ($this->enabled == true) ? true : false;
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
