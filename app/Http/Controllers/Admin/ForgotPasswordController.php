<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request , $from_api = false)
    {
        $messages = [
            'email.required' => 'البريد الالكتروني مطلوب.',
            'email.email' => 'ادخل بريد الكتروني صالح.'
        ];

        $this->validate($request, [
            'email' => 'required|email'
        ], $messages);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );
        
        return $response;
        if(!$from_api){
            if ( $response == Password::RESET_LINK_SENT ) {
                session()->flash('success', 'تم إرسال رسالة إلى بريدك تحتوي على رابط تغيير كلمة المرور.');
                return back();
            }
            if ( $response == Password::INVALID_USER ) {
                session()->flash('fail', 'لم نجد اداري بهذا البريد.');
                return back();
            }
        }else{
            if ($response == Password::RESET_LINK_SENT ){
               return "send";
            }
            if ( $response == Password::INVALID_USER ){
               return "admin not found" ; 
            }
        }
    }

    public function broker()
    {
        return Password::broker('admins');
    }
}
