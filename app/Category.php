<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post', 'category_id', 'id');
    }
    public function latest_posts() {
        return $this->posts()->orderBy('created_at' , 'desc');
    }
}
