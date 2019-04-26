<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    protected $fillable = [
        'category_id',
        'page_id',
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
