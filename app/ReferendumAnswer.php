<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferendumAnswer extends Model
{
    protected $fillable = [
        'referendum_id',
        'answer',
    ];

    public function votes()
    {
        return $this->hasMany('App\ReferendumVotes', 'referendum_answer_id', 'id');
    }
}
