<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referendum extends Model
{
    protected $fillable = [
        'title',
        'activated',
    ];

    public function answers()
    {
        return $this->hasMany('App\ReferendumAnswer', 'referendum_id', 'id');
    }
}
