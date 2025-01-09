<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function drills()
    {
        return $this->hasMany('App\Drill', 'category_id', 'id');
    }
}
