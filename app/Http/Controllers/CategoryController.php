<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::all()
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'slug.required' => 'الرابط مطلوب.',
            'slug.regex' => 'الرابط يتكون من حروف انجليزية كبيرة او صغيرة وارقام والعلامة (-).',
            'slug.unique' => 'الرابط موجود مسبقا.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:categories'
        ], $messages);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        session()->flash('success', 'تم اضافة القسم.');
        return redirect()->route('categories');
    }

    public function edit(Request $request, $id)
    {
        $category = Category::find($id);

        if ( count($category) == 0 )
        {
            session()->flash('info', 'لا يوجد قسم بهذا الرقم.');
            return redirect()->route('categories');
        }

        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if ( count($category) == 0 )
        {
            session()->flash('info', 'لا يوجد قسم بهذا الرقم.');
            return redirect()->route('categories');
        }

        $messages = [
            'name.required' => 'الاسم مطلوب.',
            'slug.required' => 'الرابط مطلوب.',
            'slug.regex' => 'الرابط يتكون من حروف انجليزية كبيرة او صغيرة وارقام والعلامة (-).',
            'slug.unique' => 'الرابط موجود مسبقا.',
        ];

        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|regex:/^[a-zA-Z0-9-]+$/|unique:categories,slug,'.$category->id,
        ], $messages);

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        session()->flash('success', 'تم تعديل القسم.');
        return redirect()->route('categories');
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::find($id);

        if ( count($category) == 0 )
        {
            session()->flash('info', 'لا يوجد قسم بهذا الرقم.');
            return redirect()->route('categories');
        }

        // updating all news in that category
        foreach ( Post::where('category_id', $id)->get() as $new ) {
            $new->update([
                'category_id' => null
            ]);
        }

        $category->delete();

        session()->flash('success', 'تم حذف القسم.');
        return redirect()->route('categories');
    }
}
