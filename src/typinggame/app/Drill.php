<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drill extends Model
{
    protected $fillable = ['user_id', 'title', 'category_id', 'difficulty'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scores()
    {
        return $this->hasMany('App\Score');
    }

    public function problems()
    {
        return $this->hasMany('App\Problem');
    }

    public function score_user()
    {
        return $this->belongsTo('App\User', 'high_score_user_id');
    }
}
