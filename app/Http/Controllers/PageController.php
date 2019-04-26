<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        return view('admin.pages.index', [
            'pages' => Page::all()
        ]);
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'العنوان مطلوب.',
            'content.required' => 'المحتوى مطلوب.',
            'slug.required' => 'الرابط مطلوب.',
            'slug.regex' => 'الرابط يتكون من حروف انجليزية كبيرة او صغيرة وارقام والعلامة (-).',
            'slug.unique' => 'الرابط موجود مسبقا.',
        ];

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pages',
        ], $messages);


        Page::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
        ]);

        session()->flash('success', 'تم اضافة الصفحة.');
        return redirect()->route('pages');
    }

    public function edit(Request $request, $id)
    {
        $page = Page::find($id);

        if ( count($page) == 0 )
        {
            session()->flash('info', 'لا يوجد صفحة بهذا الرقم.');
            return redirect()->route('pages');
        }

        return view('admin.pages.edit', [
            'pageContent' => $page,
        ]);
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        if ( count($page) == 0 )
        {
            session()->flash('info', 'لا يوجد صفحة بهذا الرقم.');
            return redirect()->route('pages');
        }

        $messages = [
            'title.required' => 'العنوان مطلوب.',
            'content.required' => 'المحتوى مطلوب.',
            'slug.required' => 'الرابط مطلوب.',
            'slug.regex' => 'الرابط يتكون من حروف انجليزية كبيرة او صغيرة وارقام والعلامة (-).',
            'slug.unique' => 'الرابط موجود مسبقا.',
        ];

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:pages,slug,'.$page->id,
        ], $messages);


        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
        ]);

        session()->flash('success', 'تم تعديل الصفحة.');
        return redirect()->route('pages');
    }

    public function destroy(Request $request, $id)
    {
        $page = Page::find($id);

        if ( count($page) == 0 )
        {
            session()->flash('info', 'لا يوجد صفحة بهذا الرقم.');
            return redirect()->route('pages');
        }

        // prevent delete contact us page
        if ( $id == 1 )
        {
            session()->flash('info', 'لا يمكنك حذف صفحة اتصل بنا ، يمكنك فقط ايقافها.');
            return redirect()->route('pages');
        }
        // prevent delete essays page
        if ( $id == 2 )
        {
            session()->flash('info', 'لا يمكنك حذف صفحة المقالات ، يمكنك فقط ايقافها.');
            return redirect()->route('pages');
        }

        $page->delete();

        session()->flash('success', 'تم حذف الصفحة.');
        return redirect()->route('pages');
    }

    public function activate(Request $request, $id)
    {
        $page = Page::find($id);

        if ( count($page) == 0 )
        {
            session()->flash('info', 'لا يوجد صفحة بهذا الرقم.');
            return redirect()->route('pages');
        }

        $page->update([
            'content' => 1,
        ]);

        session()->flash('success', 'تم تنشيط الصفحة.');
        return redirect()->route('pages');
    }

    public function deactivate(Request $request, $id)
    {
        $page = Page::find($id);

        if ( count($page) == 0 )
        {
            session()->flash('info', 'لا يوجد صفحة بهذا الرقم.');
            return redirect()->route('pages');
        }

        $page->update([
            'content' => 0,
        ]);

        session()->flash('success', 'تم ايقاف الصفحة.');
        return redirect()->route('pages');
    }
}
