<?php

namespace App;

use App\Notifications\ForgotPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ForgotPassword($token));
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'image_id',
        'bio',
        'add_news',
        'add_essays',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id');
    }

    public function categories()
    {
        return $this->hasMany('App\WriterCategory', 'writer_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'writer_id', 'id');
    }
}
