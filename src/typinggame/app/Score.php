<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['score', 'user_id', 'drill_id'];


    public function drill()
    {
        return $this->belongsTo('App\Drill');
    }
}
