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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function followee(){
        return $this->belongsToMany('App\User', 'relations', 'user_id', 'follow_id');
    }
    public function follower(){
        return $this->belongsToMany('App\User', 'relations', 'follow_id', 'user_id');
    }

    public function profile(){
        return $this->hasOne('App\Profile');
    }
}
