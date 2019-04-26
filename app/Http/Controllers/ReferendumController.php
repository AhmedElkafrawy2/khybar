<?php

namespace App\Http\Controllers;

use App\Referendum;
use App\ReferendumVotes;
use Illuminate\Http\Request;

class ReferendumController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.referendum.index', [
            'referendum' => Referendum::find(1)
        ]);
    }
    public function edit()
    {
        return view('admin.referendum.edit', [
            'referendum' => Referendum::find(1)
        ]);
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ], [
            'title.required' => 'السؤال مطلوب.'
        ]);

        Referendum::find(1)->update([
            'title' => $request->title
        ]);

        session()->flash('success', 'تم تعديل الاستفتاء.');
        return redirect()->route('referendum');
    }
    public function activate()
    {
        Referendum::find(1)->update([
            'activated' => 1,
        ]);

        session()->flash('success', 'تم تنشيط الاستفتاء.');
        return redirect()->route('referendum');
    }
    public function deactivate()
    {
        Referendum::find(1)->update([
            'activated' => 0,
        ]);

        session()->flash('success', 'تم ايقاف الاستفتاء.');
        return redirect()->route('referendum');
    }
    public function reset()
    {
        ReferendumVotes::truncate();

        session()->flash('success', 'تم تصفير الاصوات.');
        return redirect()->route('referendum');
    }
}
