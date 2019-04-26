<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $messages = [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'ادخل عنوان بريد إلكتروني صالح.',
            'password.required'  => 'كلمة المرور مطلوبة.',
            'password.min'  => 'يجب أن تتكون كلمة المرور من 6 حروف أو أرقام أو رموز على الأقل.',
        ];

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], $messages);

        $admin = Admin::where('email', $request->email)->first();

        if ( !count($admin) ){
            session()->flash('fail', 'لم نجد أي سجلات لهذا البريد الالكتروني.');
            return back()->withInput();
        }

        if ( !auth()->guard('admin')->attempt(['email' =>  $request->email, 'password' =>  $request->password]) ) {
            session()->flash('fail', 'كلمة المرور خاطئة.');
            return back()->withInput();
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        return redirect('/admin');
    }
}
