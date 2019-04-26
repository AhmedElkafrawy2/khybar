<?php

namespace App\Http\Controllers;

use App\ReferendumAnswer;
use Illuminate\Http\Request;

class ReferendumAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        return view('admin.referendum.choices.index', [
            'choices' => ReferendumAnswer::all()
        ]);
    }

    public function create()
    {
        return view('admin.referendum.choices.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'answer' => 'required'
        ], [
            'answer.required' => 'السؤال مطلوب.'
        ]);

        ReferendumAnswer::create([
            'referendum_id' => 1,
            'answer' => $request->answer
        ]);

        session()->flash('success', 'تم اضافة الاختيار.');
        return redirect()->route('referendum.choices');
    }

    public function destroy($id)
    {
        ReferendumAnswer::find($id)->delete();
        session()->flash('success', 'تم حذف الاختيار.');
        return redirect()->route('referendum.choices');
    }
}
