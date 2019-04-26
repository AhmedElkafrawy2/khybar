<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffer extends Model
{
    protected $fillable = [
        'name',
        'job_title',
        'image_id'
    ];
    protected $table    = "staffer";
    
    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id');
    }

}
