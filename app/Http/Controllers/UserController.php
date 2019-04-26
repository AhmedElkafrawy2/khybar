<?php

namespace App\Http\Controllers;

use App\User;
use App\Comment;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.users.index', [
            'users' => User::all()
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد مطلوب.',
            'email.email' => 'بريد غير صالح.',
            'email.unique' => 'هذا البريد مسجل من قبل.',
            'phone.required' => 'رقم الجوال مطلوب',
            'phone.numeric' => 'رقم الجوال غير صالح',
            'password.required'  => 'كلمة المرور مطلوبة.',
            'password.min'  => 'يجب أن تتكون كلمة المرور من 6 حروف أو أرقام أو رموز على الأقل.',
            'password.confirmed'  => 'تاكيد كلمة المرور غير متطابق.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions' => 'نسبة أبعاد الصورة يجب أن تكون 1/1.',
        ];

        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|numeric',
            'password' => 'required|min:6|confirmed',
        ], $messages);

        $image_id = null;
        // if there was an image upload it and override the image_id var
        if ( $request->image )
        {
            $this->validate($request, [
                'image' => 'mimes:jpg,jpeg,png',
            ], $messages);

            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('users', 'public');

            $image_id = $image->id;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'image_id' => $image_id,
            'bio' => $request->bio,
        ]);

        session()->flash('success', 'تم اضافة العضو.');
        return redirect()->route('users');
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);

        if ( count($user) == 0 )
        {
            session()->flash('info', 'لا يوجد عضو بهذا الرقم.');
            return redirect()->route('users');
        }

        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ( count($user) == 0 )
        {
            session()->flash('info', 'لا يوجد عضو بهذا الرقم.');
            return redirect()->route('users');
        }

        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد مطلوب.',
            'email.email' => 'بريد غير صالح.',
            'email.unique' => 'هذا البريد مسجل من قبل.',
            'phone.required' => 'رقم الجوال مطلوب',
            'phone.numeric' => 'رقم الجوال غير صحيح',
            'password.required'  => 'كلمة المرور مطلوبة.',
            'password.min'  => 'يجب أن تتكون كلمة المرور من 6 حروف أو أرقام أو رموز على الأقل.',
            'password.confirmed'  => 'تاكيد كلمة المرور غير متطابق.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions' => 'نسبة أبعاد الصورة يجب أن تكون 1/1.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|numeric',
        ], $messages);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
        ]);

        if ( $request->image )
        {
            $this->validate($request, [
                'image' => 'mimes:jpg,jpeg,png',
            ], $messages);

            if ( $user->image_id )
            {
                Storage::delete('public/users/'.$user->image()->first()->filename); // delete the image from storage
                $user->image()->delete(); // delete image record from images table
            }

            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('users', 'public');

            $user->update([
                'image_id' => $image->id
            ]);
        }

        if ( $request->password )
        {
            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
            ], $messages);

            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        session()->flash('success', 'تم تعديل العضو.');
        return redirect()->route('users');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);

        if ( count($user) == 0 )
        {
            session()->flash('info', 'لا يوجد عضو بهذا الرقم.');
            return redirect()->route('users');
        }
        
        if($user->image_id != null){
            // delete writer's image (file and record)
            Storage::delete('public/users/'.$user->image()->first()->filename); // delete the image from storage
            
            $user->image()->delete(); // delete image record from images table
        }
        $comments = DB::table("comments")
                            ->where("user_id" , $user->id)
                            ->get();
        if(count($comments) > 0){
            // delete user's comments
            $user->comments()->delete();
        }
        // finally, delete writer's record
        $user->delete(); // finally, delete user record from user table

        session()->flash('success', 'تم حذف العضو.');
        return redirect()->route('users');
    }
}
