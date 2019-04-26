<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Category;
use App\Post;
use App\Banner;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if ( auth()->guard('admin')->user()->id == 1 )
        {
            $news = Post::where('type', 1)->get();
            $essays = Post::where('type', 2)->get();
        }
        else
        {
            $news = Post::where('type', 1)->where('writer_id', auth()->guard('admin')->user()->id)->get();
            $essays = Post::where('type', 2)->where('writer_id', auth()->guard('admin')->user()->id)->get();
        }
        return view('admin.dashboard', [
            'categories' => Category::all(),
            'news' => $news,
            'essays' => $essays,
            'banners' => Banner::all(),
        ]);
    }

    public function editAccount()
    {
        return view('admin.account');
    }

    public function updateInfoAccount(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد الالكتروني مطلوب.',
            'email.email' => 'ادخل عنوان بريد الكتروني صالح.',
        ];

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
        ], $messages);

        Admin::find(auth()->guard('admin')->user()->id)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        session()->flash('success', 'تم تعديل معلوماتك.');
        return back();
    }

    public function updatePassAccount(Request $request)
    {
        $messages = [
            'current_password.required'  => 'كلمة الحالية المرور مطلوبة.',
            'current_password.min'  => 'يجب أن تتكون كلمة المرور الحالية من 6 حروف أو أرقام أو رموز على الأقل.',
            'current_password.confirmed'  => 'تأكيد كلمة المرور غير متطابق.',
            'password.required'  => 'كلمة المرور مطلوبة.',
            'password.min'  => 'يجب أن تتكون كلمة المرور من 6 حروف أو أرقام أو رموز على الأقل.',
            'password.confirmed'  => 'تأكيد كلمة المرور غير متطابق.',
        ];

        $this->validate(request(), [
            'current_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ], $messages);

        $admin = Admin::find(auth()->guard('admin')->user()->id);

        if ( !\Hash::check($request->current_password, $admin->password) ){
            session()->flash('fail', 'كلمة المرور الحالية خاطئة.');
            return back();
        }

        $admin->password = bcrypt($request->password);
        $admin->save();
        session()->flash('success', 'تم تعديل كلمة مرور حسابك بنجاح.');
        return back();
    }
}
