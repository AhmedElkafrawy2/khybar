<?php

namespace App\Http\Controllers;

use App\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['store']]);
    }

    public function index()
    {
        return view('admin.contactuses.index', [
            'show' => 'unread',
            'contactuses' => ContactUs::where('reviewed', 0)->paginate(25),
        ]);
    }

    public function all()
    {
        return view('admin.contactuses.index', [
            'show' => 'all',
            'contactuses' => ContactUs::paginate(25),
        ]);
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد مطلوب.',
            'phone.required' => 'رقم الجوال مطلوب.',
            'phone.regex' => 'رقم الهاتف يبدأ بـ 05 ، ويتكون من 10 ارقام.',
            'email.email' => 'ادخل بريد صالح.',
            'content.required' => 'الرسالة مطلوبة.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/(05)[0-9]{8}/',
            'content' => 'required',
        ], $messages);

        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'content' => $request->content,
        ]);

        session()->flash('success', 'تم استلام رسالتك.');
        return redirect()->route('index');
    }

    public function show($id)
    {
        $contactus = ContactUs::find($id);
        if ( count($contactus) == 0 )
        {
            session()->flash('info', 'لا يوجد رسالة بهذا الرقم.');
            return redirect()->route('contactuses');
        }
        $contactus->reviewed();

        return view('admin.contactuses.show', [
            'contactus' => $contactus
        ]);
    }

    public function review($id)
    {
        $contactus = ContactUs::find($id);
        if ( count($contactus) == 0 )
        {
            session()->flash('info', 'لا يوجد رسالة بهذا الرقم.');
            return redirect()->route('contactuses');
        }
        $contactus->reviewed();

        session()->flash('success', 'تم تعليمه كمقروء.');
        return redirect()->route('contactuses');
    }

    public function destroy($id)
    {
        $contactus = ContactUs::find($id);
        if ( count($contactus) == 0 )
        {
            session()->flash('info', 'لا يوجد رسالة بهذا الرقم.');
            return redirect()->route('contactuses');
        }
        $contactus->delete();

        session()->flash('success', 'تم حذف الرسالة.');
        return redirect()->route('contactuses');
    }
}
