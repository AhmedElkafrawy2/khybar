<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferendumVotes extends Model
{
    protected $fillable = [
        'referendum_id',
        'referendum_answer_id',
        'user_id',
    ];
}
