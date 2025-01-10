<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['drill_id', 'question', 'order'];

    public function drill()
    {
        return $this->belongsTo('App\Drill');
    }
}
