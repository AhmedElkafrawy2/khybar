<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Image;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        return redirect()->route('settings.edit');
    }

    public function edit()
    {
        return view('admin.settings.edit', [
            'settings' => Setting::find(1),
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request)
    {
        $messages = [
            'name.required' => 'اسم الموقع مطلوب.',
            'name.min' => 'اسم الموقع اقل من 4 حروف.',
        ];

        $this->validate($request, [
            'name' => 'required|min:4'
        ], $messages);

        Setting::find(1)->update([
            'name' => $request->name,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'sidebar_slider_category_id' => $request->sidebar_slider_category_id,
        ]);

        if ( $request->image )
        {
            Storage::delete('public/settings/'.Setting::find(1)->header()->first()->filename); // delete the image from storage
            Setting::find(1)->header()->delete(); // delete image record from images table

            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('settings', 'public');

            Setting::find(1)->update([
                'header_image_id' => $image->id
            ]);
        }
        session()->flash('success', 'تم تعديل الاعدادات.');
        return redirect()->route('settings.edit');
    }

    public function socialInHeaderActivate()
    {
        Setting::find(1)->update([
            'social_in_header' => 1
        ]);
        session()->flash('success', 'تم تفعيل روابط التواصل في الرأس.');
        return redirect()->route('settings.edit');
    }
    public function socialInHeaderDeactivate()
    {
        Setting::find(1)->update([
            'social_in_header' => 0
        ]);
        session()->flash('success', 'تم ايقاف روابط التواصل في الرأس.');
        return redirect()->route('settings.edit');
    }

    public function socialInFooterActivate()
    {
        Setting::find(1)->update([
            'social_in_footer' => 1
        ]);
        session()->flash('success', 'تم تفعيل روابط التواصل في الذيل.');
        return redirect()->route('settings.edit');
    }
    public function socialInFooterDeactivate()
    {
        Setting::find(1)->update([
            'social_in_footer' => 0
        ]);
        session()->flash('success', 'تم ايقاف روابط التواصل في الذيل.');
        return redirect()->route('settings.edit');
    }

    public function sliderActivate()
    {
        Setting::find(1)->update([
            'slider' => 1
        ]);
        session()->flash('success', 'تم تفعيل السلايدر.');
        return redirect()->route('settings.edit');
    }
    public function sliderDeactivate()
    {
        Setting::find(1)->update([
            'slider' => 0
        ]);
        session()->flash('success', 'تم ايقاف السلايدر.');
        return redirect()->route('settings.edit');
    }

    public function randomBannersActivate()
    {
        Setting::find(1)->update([
            'random_banners' => 1
        ]);
        session()->flash('success', 'تم تفعيل البنرات العشوائية.');
        return redirect()->route('settings.edit');
    }
    public function randomBannersDeactivate()
    {
        Setting::find(1)->update([
            'random_banners' => 0
        ]);
        session()->flash('success', 'تم ايقاف البنرات العشوائية.');
        return redirect()->route('settings.edit');
    }
}
