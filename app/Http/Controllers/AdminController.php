<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Image;
use Illuminate\Support\Facades\Storage;
use App\Category;
use App\WriterCategory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'name.max' => 'يجب ألا يتجاوز الاسم 255 حرف.',
            'email.required' => 'البريد مطلوب.',
            'email.email' => 'ادخل بريد صحيح.',
            'email.max' => 'يجب ألا يتجاوز البريد 255 حرف.',
            'email.unique' => 'البريد مسجل مسبقا.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'يجب ألا تقل كلمة المرور عن 6 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions' => 'نسبة أبعاد الصورة يجب أن تكون 1/1.',
        ];

        $this->validate(Request(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email,'.auth()->guard('admin')->user()->id,
        ], $messages);

        auth()->guard('admin')->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
        ]);

        if ( $request->image )
        {
            $this->validate($request, [
                'image' => 'mimes:jpg,jpeg,png|dimensions:ratio=1/1',
            ], $messages);

            if ( auth()->guard('admin')->user()->image_id )
            {
                Storage::delete('public/writers/'.auth()->guard('admin')->user()->image()->first()->filename); // delete the image from storage
                auth()->guard('admin')->user()->image()->delete(); // delete image record from images table
            }

            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('writers', 'public');

            auth()->guard('admin')->user()->update([
                'image_id' => $image->id
            ]);
        }

        if ( $request->password )
        {
            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
            ], $messages);

            auth()->guard('admin')->user()->update([
                'password' => bcrypt($request->password),
            ]);
        }

        session()->flash('success', 'تم تعديل ملفك.');
        return redirect()->back();
    }

    // writers section ...
    public function index()
    {
        return view('admin.writers.index', [
            'writers' => Admin::all()->except(1)
        ]);
    }

    public function create()
    {
        return view('admin.writers.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد مطلوب.',
            'email.email' => 'بريد غير صالح.',
            'email.unique' => 'هذا البريد مسجل من قبل.',
            'password.required'  => 'كلمة المرور مطلوبة.',
            'password.min'  => 'يجب أن تتكون كلمة المرور من 6 حروف أو أرقام أو رموز على الأقل.',
            'password.confirmed'  => 'تاكيد كلمة المرور غير متطابق.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions' => 'نسبة أبعاد الصورة يجب أن تكون 1/1.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed',
        ], $messages);
        
        if ( !$request->add_news && !$request->add_essays )
        {
            session()->flash('info', 'لا يمكنك اضافة كاتب لا يستطيع كتابة اخبار او مقالات.');
            return redirect()->back()->withInput();
        }


        $image_id = null;
        // if there was an image upload it and override the image_id var
        if ( $request->image )
        {
            $this->validate($request, [
                'image' => 'mimes:jpg,jpeg,png|dimensions:ratio=1/1',
            ], $messages);

            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('writers', 'public');

            $image_id = $image->id;
        }

        $writer = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image_id' => $image_id,
            'bio' => $request->bio,
            'add_news' => $request->add_news ? 1 : 0,
            'add_essays' => $request->add_essays ? 1 : 0,
        ]);
        
        $categoryCounter = 0;
        foreach( $request->input() as $key => $value )
        {
            if ( substr ( $key, 0, 9 ) == 'category_' )
            {
                $categoryCounter++;
                WriterCategory::create([
                    'writer_id' => $writer->id,
                    'category_id' => explode('_', $key)[1],
                ]);
            }
        }

        if ( $categoryCounter == 0 )
        {
            session()->flash('info', 'لم يتم اضافة اي اقسام لهذا الكاتب ، ستكون جميع كتاباته غير مصنفه.');
        }
        
        session()->flash('success', 'تم اضافة الكاتب.');
        return redirect()->route('writers');
    }

    public function edit(Request $request, $id)
    {
        $writer = Admin::find($id);

        if ( count($writer) == 0 )
        {
            session()->flash('info', 'لا يوجد كاتب بهذا الرقم.');
            return redirect()->route('writers');
        }

        return view('admin.writers.edit', [
            'categories' => Category::all(),
            'writerCategories' => $writer->categories()->pluck('category_id')->toArray(),
            'writer' => $writer
        ]);
    }

    public function update(Request $request, $id)
    {
        $writer = Admin::find($id);

        if ( count($writer) == 0 )
        {
            session()->flash('info', 'لا يوجد كاتب بهذا الرقم.');
            return redirect()->route('writers');
        }

        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد مطلوب.',
            'email.email' => 'بريد غير صالح.',
            'email.unique' => 'هذا البريد مسجل من قبل.',
            'password.required'  => 'كلمة المرور مطلوبة.',
            'password.min'  => 'يجب أن تتكون كلمة المرور من 6 حروف أو أرقام أو رموز على الأقل.',
            'password.confirmed'  => 'تاكيد كلمة المرور غير متطابق.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions' => 'نسبة أبعاد الصورة يجب أن تكون 1/1.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$writer->id,
        ], $messages);

        if ( !$request->add_news && !$request->add_essays )
        {
            session()->flash('info', 'لا يمكنك اضافة كاتب لا يستطيع كتابة اخبار او مقالات.');
            return redirect()->back()->withInput();
        }

        // delete writer's categories and recreate them.
        $writer->categories()->delete();

        $writer->update([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
            'add_news' => $request->add_news ? 1 : 0,
            'add_essays' => $request->add_essays ? 1 : 0,
        ]);

        if ( $request->image )
        {
            $this->validate($request, [
                'image' => 'mimes:jpg,jpeg,png|dimensions:ratio=1/1',
            ], $messages);

            if ( $writer->image_id )
            {
                Storage::delete('public/writers/'.$writer->image()->first()->filename); // delete the image from storage
                $writer->image()->delete(); // delete image record from images table
            }

            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('writers', 'public');

            $writer->update([
                'image_id' => $image->id
            ]);
        }

        if ( $request->password )
        {
            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
            ], $messages);

            $writer->update([
                'password' => bcrypt($request->password),
            ]);
        }

        $categoryCounter = 0;
        foreach( $request->input() as $key => $value )
        {
            if ( substr ( $key, 0, 9 ) == 'category_' )
            {
                $categoryCounter++;
                WriterCategory::create([
                    'writer_id' => $writer->id,
                    'category_id' => explode('_', $key)[1],
                ]);
            }
        }

        if ( $categoryCounter == 0 )
        {
            session()->flash('info', 'لم يتم اضافة اي اقسام لهذا الكاتب ، ستكون جميع كتاباته غير مصنفه.');
        }
        session()->flash('success', 'تم تعديل الكاتب.');
        return redirect()->route('writers');
    }

    public function destroy(Request $request, $id)
    {
        $writer = Admin::find($id);

        if ( count($writer) == 0 )
        {
            session()->flash('info', 'لا يوجد كاتب بهذا الرقم.');
            return redirect()->route('writers');
        }

        // delete writer's image (file and record) if he had uploaded one
        if ( $writer->image_id !== null ){
            Storage::delete('public/writers/'.$writer->image()->first()->filename); // delete the image from storage
            $writer->image()->delete(); // delete image record from images table
        }
        

        // delete writer's posts
        $writer->posts()->delete();

        // finally, delete writer's record
        $writer->delete(); // finally, delete writer record from writers table

        session()->flash('success', 'تم حذف الكاتب.');
        return redirect()->route('writers');
    }
}
