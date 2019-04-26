<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'type',
        'title',
        'content',
        'description',
        'slug',
        'category_id',
        'writer_id',
        'image_id',
        'comments',
        'breakingnews',
        'slide',
        'slider_date',
        'post_source'
    ];

    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function writer()
    {
        return $this->hasOne('App\Admin', 'id', 'writer_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }
    public function available_comments() {
        return $this->comments()->where('approved','=', 1);
    }
}
