<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $fillable = ['drill_id', 'question', 'order'];

    public function drill()
    {
        return $this->belongsTo('App\Drill');
    }
}
