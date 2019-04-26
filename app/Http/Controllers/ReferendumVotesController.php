<?php

namespace App\Http\Controllers;

use App\ReferendumVotes;
use Illuminate\Http\Request;

class ReferendumVotesController extends Controller
{
    public function store(Request $request)
    {
        $vote = 0;
        $answer = null;
        foreach( $request->input() as $key => $value )
        {
            if ( substr ( $key, 0, 7 ) == 'answer_' )
            {
                $vote++;
                $answer = $value;
            }
        }
        if ( $vote == 0 )
        {
            session()->flash('info', 'لم تقم بتحديد اختيار.');
            return redirect()->route('index');
        }

        ReferendumVotes::create([
            'referendum_id' => 1,
            'referendum_answer_id' => $answer,
            'user_id' => auth()->user()->id,
        ]);

        session()->flash('success', 'تم استلام صوتك.');
        return redirect()->route('index');
    }
}
