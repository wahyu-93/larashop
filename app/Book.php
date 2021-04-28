<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function Categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
