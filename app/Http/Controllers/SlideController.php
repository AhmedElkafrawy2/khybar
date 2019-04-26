<?php

namespace App\Http\Controllers;

use App\Slide;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        return view('admin.slides.index', [
            'slides' => Slide::all()
        ]);
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'العنوان مطلوب.',
            'description.required' => 'الوصف مطلوب.',
            'image.required' => 'الصورة مطلوبة.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions.ratio' => 'نسبة أبعاد الصورة يجب أن تكون 3/2.',
        ];

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,png|dimensions:ratio=3/2',
        ], $messages);

        $image = Image::create([
            'filename' => $request->image->hashName(),
            'filetype' => $request->image->getSize(),
            'filesize' => $request->image->getMimeType(),
        ]);

        $request->image->store('slides', 'public');

        Slide::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_id' => $image->id,
        ]);

        session()->flash('success', 'تم اضافة الشريحة.');
        return redirect()->route('slides');
    }

    public function edit(Request $request, $id)
    {
        $slide = Slide::find($id);

        if ( count($slide) == 0 )
        {
            session()->flash('info', 'لا يوجد شريحة بهذا الرقم.');
            return redirect()->route('slides');
        }

        return view('admin.slides.edit', [
            'slide' => $slide
        ]);
    }

    public function update(Request $request, $id)
    {
        $slide = Slide::find($id);

        if ( count($slide) == 0 )
        {
            session()->flash('info', 'لا يوجد شريحة بهذا الرقم.');
            return redirect()->route('sldies');
        }

        $messages = [
            'title.required' => 'العنوان مطلوب.',
            'description.required' => 'الوصف مطلوب.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions.ratio' => 'نسبة أبعاد الصورة يجب أن تكون 3/2.',
        ];

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'mimes:jpeg,png|dimensions:ratio=3/2',
        ], $messages);

        $slide->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ( $request->image )
        {
            // delete exsiting image first
            Storage::delete('public/slides/'.$slide->image()->first()->filename); // delete the image from storage
            Image::find($slide->image_id)->delete();

            // then upload the new one
            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('slides', 'public');

            // finally, update image id
            $slide->update([
                'image_id' => $image->id,
            ]);
        }

        session()->flash('success', 'تم تعديل الشريحة.');
        return redirect()->route('slides');
    }

    public function destroy(Request $request, $id)
    {
        $slide = Slide::find($id);

        if ( count($slide) == 0 )
        {
            session()->flash('info', 'لا يوجد شريحة بهذا الرقم.');
            return redirect()->route('sldies');
        }

        Storage::delete('public/slides/'.$slide->image()->first()->filename); // delete the image from storage
        Image::find($slide->image_id)->delete(); // delete image record from images table
        $slide->delete(); // finally, delete slide record from slides table

        session()->flash('success', 'تم حذف الشريحة.');
        return redirect()->route('slides');
    }
}
