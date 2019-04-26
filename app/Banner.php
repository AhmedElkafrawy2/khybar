<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'position',
        'image_id',
    ];
    
    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id');
    }
}
