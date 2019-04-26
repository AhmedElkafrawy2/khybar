<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_id',
    ];

    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id');
    }
}
