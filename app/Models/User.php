<?php

namespace SQLgreyGUI\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'enabled',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * get id.
     *
     * @return int
     */
    public function getId()
    {
        return intval($this->id);
    }

    /**
     * get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * get updated at.
     *
     * @return \Carbon\Carbon
     */
    public function getUpdatedAt()
    {
        return new Carbon($this->updated_at);
    }

    /**
     * get created at.
     *
     * @return \Carbon\Carbon
     */
    public function getCreatedAt()
    {
        return new Carbon($this->created_at);
    }

    /**
     * is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return ($this->enabled == true) ? true : false;
    }

    /**
     * set username.
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * set password.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Hash::make($password);
    }

    /**
     * set email.
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * set enabled.
     *
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        if ($enabled === true) {
            $this->enabled = true;
        } else {
            $this->enabled = false;
        }
    }
}
