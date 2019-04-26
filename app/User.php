<?php

namespace App;

use App\Notifications\ForgotPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
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
        'phone',
        'device_reg_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id');
    }

    public function comments()
    {
        return $this->hasMany('\App\Comment', 'user_id', 'id');
    }

    public function vote()
    {
        return $this->hasOne('App\ReferendumVotes', 'user_id', 'id');
    }
}
