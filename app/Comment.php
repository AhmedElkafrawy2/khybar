<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'approved',
        'name'
    ];

    public function reviewed()
    {
        $this->reviewed = 1;
        $this->save();
    }
    
    public function activate()
    {
        $this->approved = 1;
        $this->save();
    }
    public function deactivate()
    {
        $this->approved = 0;
        $this->save();
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id', 'id');
    }

}
