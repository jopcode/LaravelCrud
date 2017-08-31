<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = array('title', 'content', 'user');
    public function Comments() {
        return $this->hasMany('App\Comment');
    }
}
