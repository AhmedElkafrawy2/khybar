<?php

namespace App\Http\Controllers;

use App\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        return view('admin.sociallinks.index', [
            'sociallinks' => SocialLink::all()
        ]);
    }

    public function create()
    {
        return view('admin.sociallinks.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'icon.required' => 'الايقونه مطلوبة.',
            'link.required' => 'الرابط مطلوب.',
            'color.required' => 'اللون مطلوب.',
            'color.max' => 'اللون مكون من 6 خانات.',
            'color.min' => 'اللون مكون من 6 خانات.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'icon' => 'required',
            'link' => 'required',
            'color' => 'required|max:6|min:6'
        ], $messages);

        SocialLink::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'link' => $request->link,
            'color' => $request->color,
        ]);

        session()->flash('success', 'تم اضافة الرابط.');
        return redirect()->route('sociallinks');
    }

    public function edit(Request $request, $id)
    {
        $sociallink = SocialLink::find($id);

        if ( count($sociallink) == 0 )
        {
            session()->flash('info', 'لا يوجد رابط بهذا الرقم.');
            return redirect()->route('sociallinks');
        }

        return view('admin.sociallinks.edit', [
            'sociallink' => $sociallink
        ]);
    }

    public function update(Request $request, $id)
    {
        $sociallink = SocialLink::find($id);

        if ( count($sociallink) == 0 )
        {
            session()->flash('info', 'لا يوجد رابط بهذا الرقم.');
            return redirect()->route('sociallinks');
        }

        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'icon.required' => 'الايقونه مطلوبة.',
            'link.required' => 'الرابط مطلوب.',
            'color.required' => 'اللون مطلوب.',
            'color.max' => 'اللون مكون من 6 خانات.',
            'color.min' => 'اللون مكون من 6 خانات.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'icon' => 'required',
            'link' => 'required',
            'color' => 'required|max:6|min:6'
        ], $messages);

        $sociallink->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'link' => $request->link,
            'color' => $request->color,
        ]);

        session()->flash('success', 'تم تعديل الرابط.');
        return redirect()->route('sociallinks');
    }

    public function destroy(Request $request, $id)
    {
        $sociallink = SocialLink::find($id);

        if ( count($sociallink) == 0 )
        {
            session()->flash('info', 'لا يوجد رابط بهذا الرقم.');
            return redirect()->route('sociallinks');
        }

        $sociallink->delete();

        session()->flash('success', 'تم حذف الرابط.');
        return redirect()->route('sociallinks');
    }
}
