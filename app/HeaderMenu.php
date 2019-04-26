<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderMenu extends Model
{
    protected $fillable = [
        'category_id',
        'page_id',
        'level',
        'parent_id',
        'order',
    ];

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function page()
    {
        return $this->hasOne('App\Page', 'id', 'page_id');
    }
}
