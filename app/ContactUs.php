<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'contact_uses';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'content',
        'reviewed',
    ];

    public function reviewed()
    {
        $this->reviewed = 1;
        $this->save();
    }
}
