<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'content'
    ];

    public function comment(){
        return $this->hasMany('App\Comment');
    }

    public function like(){
        return $this->hasMany('App\Like');
    }
    public function backup(){
        return $this->hasMany('App\Backup');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
