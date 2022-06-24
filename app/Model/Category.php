<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function Posts(){
        return $this->hasMany('App\Model\Post');
    }
}
