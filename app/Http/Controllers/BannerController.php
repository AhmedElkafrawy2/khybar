<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.banners.index', [
            'banners' => Banner::all()
        ]);
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'position.required' => 'الموقع مطلوب.',
            'image.required' => 'الصورة مطلوبة.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
        ];

        $this->validate($request, [
            'position' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ], $messages);

        if ( $request->position == 1 ) // position = 1 => banner is in the right column, so it's ratio must be 4/1
        {
            $messages = [
                'image.dimensions' => 'نسبة أبعاد الصورة يجب أن تكون 1/8.',
            ];
            $this->validate($request, [
                'image' => 'dimensions:ratio=8/1',
            ], $messages);
        }

        if ( $request->position == 2 ) // position = 2 => banner is in the left column, so it's ratio must be 1/1
        {
            $messages = [
                'image.dimensions' => 'نسبة أبعاد الصورة يجب أن تكون 1/1.',
            ];
            $this->validate($request, [
                'image' => 'dimensions:ratio=1/1',
            ], $messages);
        }

        $image = Image::create([
            'filename' => $request->image->hashName(),
            'filetype' => $request->image->getSize(),
            'filesize' => $request->image->getMimeType(),
        ]);

        $request->image->store('banners', 'public');

        Banner::create([
            'position' => $request->position,
            'image_id' => $image->id,
        ]);

        session()->flash('success', 'تم اضافة البنر.');
        return redirect()->route('banners');
    }

    public function edit(Request $request, $id)
    {
        $banner = Banner::find($id);

        if ( count($banner) == 0 )
        {
            session()->flash('info', 'لا يوجد بنر بهذا الرقم.');
            return redirect()->route('banners');
        }

        return view('admin.banners.edit', [
            'banner' => $banner
        ]);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        if ( count($banner) == 0 )
        {
            session()->flash('info', 'لا يوجد بنر بهذا الرقم.');
            return redirect()->route('banners');
        }

        $messages = [
            'position.required' => 'الموقع مطلوب.',
            'image.required' => 'الصورة مطلوبة.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
        ];

        $this->validate($request, [
            'position' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ], $messages);

        $banner->update([
            'position' => $request->position,
        ]);

        if ( $request->image )
        {
            if ( $request->position == 1 ) // position = 1 => banner is in the right column, so it's ratio must be 4/1
            {
                $messages = [
                    'image.dimensions.ratio' => 'نسبة أبعاد الصورة يجب أن تكون 1/8.',
                ];
                $this->validate($request, [
                    'image' => 'dimensions:ratio=8/1',
                ], $messages);
            }

            if ( $request->position == 2 ) // position = 2 => banner is in the left column, so it's ratio must be 1/1
            {
                $messages = [
                    'image.dimensions.ratio' => 'نسبة أبعاد الصورة يجب أن تكون 1/1.',
                ];
                $this->validate($request, [
                    'image' => 'dimensions:ratio=1/1',
                ], $messages);
            }

            // delete exsiting image first
            Storage::delete('public/banners/'.$banner->image()->first()->filename); // delete the image from storage
            Image::find($banner->image_id)->delete();

            // then upload the new one
            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('banners', 'public');

            // finally, update image id
            $banner->update([
                'image_id' => $image->id,
            ]);
        }

        session()->flash('success', 'تم تعديل البنر.');
        return redirect()->route('banners');
    }

    public function destroy(Request $request, $id)
    {
        $banner = Banner::find($id);

        if ( count($banner) == 0 )
        {
            session()->flash('info', 'لا يوجد بنر بهذا الرقم.');
            return redirect()->route('banners');
        }

        Storage::delete('public/banners/'.$banner->image()->first()->filename); // delete the image from storage
        Image::find($banner->image_id)->delete(); // delete image record from images table
        $banner->delete(); // finally, delete slide record from slides table

        session()->flash('success', 'تم حذف البنر.');
        return redirect()->route('banners');
    }
}
