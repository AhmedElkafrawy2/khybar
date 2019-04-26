<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'name',
        'meta_keywords',
        'meta_description',
        'header_image_id',
        'sidebar_slider_category_id',
        'notes',
        'slider',
        'random_banners',
        'social_in_header',
        'social_in_footer',
    ];

    public function header()
    {
        return $this->hasOne('App\Image', 'id', 'header_image_id');
    }
}
