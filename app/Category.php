<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts() {
        //una categoria può essere associata a molti post
        return $this->hasMany('App\Post');
    }
}
