<?php

namespace App\Http\Controllers;

use App\Post;
use App\Image;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\PushNotification;
use DB;
class PostController extends Controller
{
    // news section ...
    public function newsIndex()
    {
        if ( auth()->guard('admin')->user()->id == 1 )
        {
            $news = Post::where('type', 1)
                    ->orderBy('created_at' , 'desc')
                    ->paginate(20);
        }
        else
        {
            if ( !auth()->guard('admin')->user()->add_news )
            {
                session()->flash('fail', 'غير مسموح لك الوصول الى هذا الرابط.');
                return redirect()->route('dashboard');
            }
            $news = Post::where('type', 1)
                            ->where('writer_id', auth()->guard('admin')->user()->id)
                            ->orderBy('created_at' , 'desc')
                            ->paginate(20);
        }
        return view('admin.news.index', [
            'news' => $news
        ]);
    }

    public function newsCreate()
    {
        if ( auth()->guard('admin')->user()->id == 1 )
        {
            $categories = Category::all();
        }
        else
        {
            $categories = [];
            foreach ( auth()->guard('admin')->user()->categories()->get() as $writerCategory )
            {
                $categories[] = $writerCategory->category()->first();
            }

        }
        return view('admin.news.create', [
            'categories' => $categories
        ]);
    }

    public function newsStore(Request $request)
    {

        $messages = [
            'title.required' => 'العنوان مطلوب.',
            'content.required' => 'المحتوى مطلوب.',
            'description.required' => 'الملخص مطلوب.',
            // 'slug.required' => 'الرابط مطلوب.',
            // 'slug.regex' => 'الرابط يتكون من حروف انجليزية كبيرة او صغيرة وارقام والعلامة (-).',
            // 'slug.unique' => 'الرابط موجود مسبقا.',
            'category_id.exists' => 'القسم غير موجود في الاقسام.',
            'image.required' => 'الصورة مطلوبة.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions.ratio' => 'نسبة أبعاد الصورة يجب أن تكون 3/2.',
            'date.required'    => 'تاريخ الغاء الخبر من السلايدر مطلوب',
        ];
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'description' => 'required',
            // 'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:posts',
            'image' => 'required|mimes:jpg,jpeg,png',
        ];
        if ($request->slide){
            $rules['date'] = "required";
        }
        $this->validate($request, $rules , $messages);

        if ( $request->category_id ){
            $this->validate($request, [
                'category_id' => 'exists:categories,id',
            ], $messages);
        }
       
        $image = Image::create([
            'filename' => $request->image->hashName(),
            'filetype' => $request->image->getSize(),
            'filesize' => $request->image->getMimeType(),
        ]);

        $request->image->store('news', 'public');

        // if stop comments was checked so comments will 0 otherwise 1
        $request->comments ? $comments = 0 : $comments = 1;
        // if brekingnews was checked so breakingnews will 1 otherwise 0
        // $request->breakingnews ? $breakingnews = 1 : $breakingnews = 0;
        // if slide was checked so slide will 1 otherwise 0
        $request->slide ? $slide  = 1 : $slide = 0;
        $request->source? $source = $request->source : $source = "صحيفة خيبر الاخبارية";
        Post::create([
                    'type' => 1,
                    'title' => $request->title,
                    'content' => $request->content,
                    'description' => $request->description,
                    'slug' => preg_replace('/[^A-Za-z0-9-]+/', '-', \Carbon\Carbon::now()),
                    'category_id' => $request->category_id,
                    'writer_id' => auth()->guard('admin')->user()->id,
                    'image_id' => $image->id,
                    'comments'    => $comments,
                    'post_source' => $source,
                    // 'breakingnews' => $breakingnews,
                    'slide' => $slide,
                    'slider_date' => $request->date,
         ]);
         session()->flash('success', 'تم اضافة الخبر.');
         return redirect()->route('news');
    }

    public function newsEdit(Request $request, $id)
    {
        $new = Post::find($id);

        if ( count($new) == 0 )
        {
            session()->flash('info', 'لا يوجد خبر بهذا الرقم.');
            return redirect()->route('news');
        }

        if ( $new->type != 1 )
        {
            session()->flash('info', 'لا يوجد خبر بهذا الرقم.');
            return redirect()->route('news');
        }

        return view('admin.news.edit', [
            'new' => $new,
            'categories' => Category::all()
        ]);
    }

    public function newsUpdate(Request $request, $id)
    {
        $new = Post::find($id);

        if ( count($new) == 0 )
        {
            session()->flash('info', 'لا يوجد خبر بهذا الرقم.');
            return redirect()->route('news');
        }

        if ( $new->type != 1 )
        {
            session()->flash('info', 'لا يوجد خبر بهذا الرقم.');
            return redirect()->route('news');
        }

        $messages = [
            'title.required' => 'العنوان مطلوب.',
            'content.required' => 'المحتوى مطلوب.',
            'description.required' => 'الملخص مطلوب.',
            // 'slug.required' => 'الرابط مطلوب.',
            // 'slug.regex' => 'الرابط يتكون من حروف انجليزية كبيرة او صغيرة وارقام والعلامة (-).',
            // 'slug.unique' => 'الرابط موجود مسبقا.',
            'category_id.exists' => 'القسم غير موجود في الاقسام.',
            'image.required' => 'الصورة مطلوبة.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions.ratio' => 'نسبة أبعاد الصورة يجب أن تكون 3/2.',
            'date.required'          => 'تاريخ الغاء الخبر من السلايدر مطلوب',
        ];
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'description' => 'required',
            // 'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:posts,slug,'.$new->id,
        ];
        if ( $request->slide ){
            $rules['date'] = "required";
        }
        $this->validate($request, $rules , $messages);

        if ( $request->category_id ){
            $this->validate($request, [
                'category_id' => 'exists:categories,id',
            ], $messages);
        }
       
        // if stop comments was check so comment will 0 otherwise 1
        $request->comments ? $comments = 0 : $comments = 1;
        // if brekingnews was checked so breakingnews will 1 otherwise 0
        // $request->breakingnews ? $breakingnews = 1 : $breakingnews = 0;
        // if slide was checked so slide will 1 otherwise 0
        $request->slide ? $slide = 1 : $slide = 0;
        $request->source? $source = $request->source : $source = "صحيفة خيبر الاخبارية";
        $new->update([
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            // 'slug' => $request->slug,
            'category_id' => $request->category_id,
            'comments' => $comments,
            // 'breakingnews' => $breakingnews,
            'slide'       => $slide,
            'post_source' => $source,
            'slider_date' => $request->date,
        ]);

        if ( $request->image )
        {
            $this->validate($request, [
                'image' => 'required|mimes:jpg,jpeg,png',
            ], $messages);

            // delete exsiting image first
            Storage::delete('public/news/'.$new->image()->first()->filename); // delete the image from storage
            Image::find($new->image_id)->delete();

            // then upload the new one
            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('news', 'public');

            // finally, update image id
            $new->update([
                'image_id' => $image->id,
            ]);
        }

        session()->flash('success', 'تم تعديل الخبر.');
        return redirect()->route('news');
    }

    public function newsDestroy(Request $request, $id)
    {
        $new = Post::find($id);

        if ( count($new) == 0 )
        {
            session()->flash('info', 'لا يوجد خبر بهذا الرقم.');
            return redirect()->route('news');
        }

        if ( $new->type != 1 )
        {
            session()->flash('info', 'لا يوجد خبر بهذا الرقم.');
            return redirect()->route('news');
        }

        Storage::delete('public/news/'.$new->image()->first()->filename); // delete the image from storage
        Image::find($new->image_id)->delete(); // delete image record from images table
        $new->delete(); // finally, delete essay record from essays table

        session()->flash('success', 'تم حذف الخبر.');
        return redirect()->route('news');
    }

    //  essays section ...
    public function essaysIndex()
    {
        if ( auth()->guard('admin')->user()->id == 1 )
        {
            $essays = Post::where('type', 2)
                            ->orderBy('created_at' , 'desc')
                            ->paginate(20);
        }
        else
        {
            if ( !auth()->guard('admin')->user()->add_essays )
            {
                session()->flash('fail', 'غير مسموح لك الوصول الى هذا الرابط.');
                return redirect()->route('dashboard');
            }
            $essays = Post::where('type', 2)
                            ->where('writer_id', auth()->guard('admin')->user()->id)
                            ->orderBy('created_at' , 'desc')
                            ->paginate(20);
        }
        return view('admin.essays.index', [
            'essays' => $essays
        ]);
    }

    public function essaysCreate()
    {
        if ( auth()->guard('admin')->user()->id == 1 )
        {
            $categories = Category::all();
        }
        else
        {
            $categories = [];
            foreach ( auth()->guard('admin')->user()->categories()->get() as $writerCategory )
            {
                $categories[] = $writerCategory->category()->first();
            }

        }
        return view('admin.essays.create', [
            'categories' => $categories
        ]);
    }

    public function essaysStore(Request $request)
    {
        $messages = [
            'title.required' => 'العنوان مطلوب.',
            'content.required' => 'المحتوى مطلوب.',
            'description.required' => 'الملخص مطلوب.',
            // 'slug.required' => 'الرابط مطلوب.',
            // 'slug.regex' => 'الرابط يتكون من حروف انجليزية كبيرة او صغيرة وارقام والعلامة (-).',
            // 'slug.unique' => 'الرابط موجود مسبقا.',
            'category_id.exists' => 'القسم غير موجود في الاقسام.',
            'image.required' => 'الصورة مطلوبة.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions.ratio' => 'نسبة أبعاد الصورة يجب أن تكون 3/2.',
        ];

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'description' => 'required',
            // 'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:posts',
            'image' => 'required|mimes:jpg,jpeg,png',
        ], $messages);

        if ( $request->category_id ){
            $this->validate($request, [
                'category_id' => 'exists:categories,id',
            ], $messages);
        }

        $image = Image::create([
            'filename' => $request->image->hashName(),
            'filetype' => $request->image->getSize(),
            'filesize' => $request->image->getMimeType(),
        ]);

        $request->image->store('essays', 'public');

        // if stop comments was check so comment will 0 otherwise 1
        $request->comments ? $comments = 0 : $comments = 1;

        Post::create([
            'type' => 2,
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            'slug' => preg_replace('/[^A-Za-z0-9-]+/', '-', \Carbon\Carbon::now()),
            'category_id' => $request->category_id,
            'writer_id' => auth()->guard('admin')->user()->id,
            'image_id' => $image->id,
            'post_source' => "صحيفة خيبر الاخبارية",
            'comments' => $comments,
        ]);

        session()->flash('success', 'تم اضافة المقال.');
        return redirect()->route('essays');
    }

    public function essaysEdit(Request $request, $id)
    {
        $essay = Post::find($id);

        if ( count($essay) == 0 )
        {
            session()->flash('info', 'لا يوجد مقال بهذا الرقم.');
            return redirect()->route('essays');
        }

        if ( $essay->type != 2 )
        {
            session()->flash('info', 'لا يوجد مقال بهذا الرقم.');
            return redirect()->route('essays');
        }

        return view('admin.essays.edit', [
            'essay' => $essay,
            'categories' => Category::all()
        ]);
    }

    public function essaysUpdate(Request $request, $id)
    {
        $essay = Post::find($id);

        if ( count($essay) == 0 )
        {
            session()->flash('info', 'لا يوجد مقال بهذا الرقم.');
            return redirect()->route('essays');
        }

        if ( $essay->type != 2 )
        {
            session()->flash('info', 'لا يوجد مقال بهذا الرقم.');
            return redirect()->route('essays');
        }

        $messages = [
            'title.required' => 'العنوان مطلوب.',
            'content.required' => 'المحتوى مطلوب.',
            'description.required' => 'الملخص مطلوب.',
            // 'slug.required' => 'الرابط مطلوب.',
            // 'slug.regex' => 'الرابط يتكون من حروف انجليزية كبيرة او صغيرة وارقام والعلامة (-).',
            // 'slug.unique' => 'الرابط موجود مسبقا.',
            'category_id.exists' => 'القسم غير موجود في الاقسام.',
            'image.required' => 'الصورة مطلوبة.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'image.dimensions.ratio' => 'نسبة أبعاد الصورة يجب أن تكون 3/2.',
        ];

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'description' => 'required',
            // 'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:posts,slug,'.$essay->id,
        ], $messages);

        if ( $request->category_id ){
            $this->validate($request, [
                'category_id' => 'exists:categories,id',
            ], $messages);
        }

        // if stop comments was check so comment will 0 otherwise 1
        $request->comments ? $comments = 0 : $comments = 1;

        $essay->update([
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            // 'slug' => $request->slug,
            'category_id' => $request->category_id,
            'comments' => $comments,
            'post_source' => "صحيفة خيبر الاخبارية",
        ]);

        if ( $request->image )
        {
            $this->validate($request, [
                'image' => 'required|mimes:jpg,jpeg,png',
            ], $messages);

            // delete exsiting image first
            Storage::delete('public/essays/'.$essay->image()->first()->filename); // delete the image from storage
            Image::find($essay->image_id)->delete();

            // then upload the new one
            $image = Image::create([
                'filename' => $request->image->hashName(),
                'filetype' => $request->image->getSize(),
                'filesize' => $request->image->getMimeType(),
            ]);

            $request->image->store('essays', 'public');

            // finally, update image id
            $essay->update([
                'image_id' => $image->id,
            ]);
        }

        session()->flash('success', 'تم تعديل المقال.');
        return redirect()->route('essays');
    }

    public function essaysDestroy(Request $request, $id)
    {
        $essay = Post::find($id);

        if ( count($essay) == 0 )
        {
            session()->flash('info', 'لا يوجد مقال بهذا الرقم.');
            return redirect()->route('essays');
        }

        if ( $essay->type != 2 )
        {
            session()->flash('info', 'لا يوجد مقال بهذا الرقم.');
            return redirect()->route('essays');
        }

        Storage::delete('public/essays/'.$essay->image()->first()->filename); // delete the image from storage
        Image::find($essay->image_id)->delete(); // delete image record from images table
        $essay->delete(); // finally, delete essay record from essays table

        session()->flash('success', 'تم حذف المقال.');
        return redirect()->route('essays');
    }
}
