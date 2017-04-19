<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_no','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hasRole($role)
    {
        if ($this->role == $role){
          return true;
        }
        else {
          return false;
        }
    }

    public function name()
    {
        if ($this->name_display) {
            return $this->name_display;
        } else {
            return $this->firstname . ' ' . $this->lastname;
        }
    }


}
