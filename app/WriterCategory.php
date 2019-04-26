<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WriterCategory extends Model
{
    protected $fillable = [
        'writer_id',
        'category_id',
    ];

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }
}
