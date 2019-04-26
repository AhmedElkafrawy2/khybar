<?php

namespace App\Http\Controllers;

use App\Post;
use App\Staffer;
use App\Image;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\PushNotification;
use DB;

class StafferController extends Controller
{

    //  essays section ...
    public function index()
    {
        if ( auth()->guard('admin')->user()->id != 1 )
        {
            session()->flash('fail', 'غير مسموح لك الوصول الى هذا الرابط.');
            return redirect()->route('dashboard');
            
        }
        $staffer = Staffer::orderBy('created_at', 'asc')->paginate(20);
        return view('admin.staffer.index', [
            'staffer' => $staffer
        ]);
    }

    public function create()
    {
        if ( auth()->guard('admin')->user()->id != 1 )
        {
            session()->flash('fail', 'غير مسموح لك الوصول الى هذا الرابط.');
            return redirect()->route('dashboard');
        }
        return view('admin.staffer.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required'      => 'الاسم مطلوب',
            'job_title.required' => 'الوظيفة مطلوبة',
            'image.required'     => 'الصورة مطلوبة.',
            'image.mimes'        => 'نوع الصورة غير مدعوم.',
        ];

        $this->validate($request, [
            'name'      => 'required',
            'job_title' => 'required',
            'image'     => 'required|mimes:jpg,jpeg,png',
        ], $messages);

        $image = Image::create([
            'filename' => $request->image->hashName(),
            'filetype' => $request->image->getSize(),
            'filesize' => $request->image->getMimeType(),
        ]);

        $request->image->store('staffer', 'public');

        Staffer::create([
            'name'      => $request->name,
            'job_title' => $request->job_title,
            'image_id' => $image->id,
        ]);

        session()->flash('success', 'تم اضافة عضو هيئة التحرير');
        return redirect()->route('staffer');
    }

    public function edit(Request $request, $id)
    {
        $staffer = Staffer::find($id);

        if ( count($staffer) == 0 )
        {
            session()->flash('info', 'لا يوجد عضو فى هيئة التحرير بهذا الرقم');
            return redirect()->route('staffer');
        }

        return view('admin.staffer.edit', [
            'staffer' => $staffer,
        ]);
    }

    public function update(Request $request, $id)
    {
        $staffer = Staffer::find($id);

        if ( count($staffer) == 0 )
        {
            session()->flash('info', 'لا يوجد عضو فى هيئة التحرير بهذا الرقم');
            return redirect()->route('staffer');
        }

        $messages = [
            'name.required' => 'الاسم مطلوب',
            'job_title.required' => 'الوظيفة مطلوبة',
            'image.required' => 'الصورة مطلوبة.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
        ];

        $this->validate($request, [
            'name'       => 'required',
            'job_title'   => 'required',
        ], $messages);



        $staffer->update([
            'name'      => $request->name,
            'job_title' => $request->job_title,
        ]);

        if ( $request->image )
        {
            $this->validate($request, [
                'image' => 'required|mimes:jpg,jpeg,png',
            ], $messages);

            // delete exsiting image first
            Storage::delete('public/staffer/'.$staffer->image()->first()->filename); // delete the image from storage
            Image::find($staffer->image_id)->delete();

            // then upload the new one
            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('staffer', 'public');

            // finally, update image id
            $staffer->update([
                'image_id' => $image->id,
            ]);
        }

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('staffer');
    }

    public function destroy(Request $request, $id)
    {
        $staffer = Staffer::find($id);

        if ( count($staffer) == 0 )
        {
            session()->flash('info', 'لا يوجد عضو فى هيئة التحرير بهذا الرقم');
            return redirect()->route('staffer');
        }

        Storage::delete('public/staffer/'.$staffer->image()->first()->filename); // delete the image from storage
        Image::find($staffer->image_id)->delete(); // delete image record from images table
        $staffer->delete(); // finally, delete essay record from essays table

        session()->flash('success', "تم الحذف بنجاح");
        return redirect()->route('staffer');
    }
}
