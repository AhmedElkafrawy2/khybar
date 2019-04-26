<?php

namespace App\Http\Controllers;

use App\HeaderMenu;
use App\Category;
use App\Page;
use Illuminate\Http\Request;

class HeaderMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        return view('admin.headermenus.index', [
            'headermenus' => HeaderMenu::orderBy('order', 'asc')->get()
        ]);
    }

    public function create()
    {
        return view('admin.headermenus.create', [
            'categories' => Category::all(),
            'pages' => Page::all()
        ]);
    }

    public function store(Request $request)
    {
        $messages = [
            'for.required' => 'يرجى تحديد ما تريد اضافته.',
            'category_id.required' => 'القسم مطلوب.',
            'page_id.required' => 'الصفحة مطلوبة.',
            'order.required' => 'الترتيب مطلوب.',
            'order.numeric' => 'الترتيب يجب أن يكون عدد.',
        ];

        $this->validate($request, [
            'for' => 'required',
        ], $messages);

        if ( $request->for == 'category' )
        {
            $this->validate($request, [
                'category_id' => 'required',
            ], $messages);
            $category_id = $request->category_id;
            $page_id = null;
        }
        else
        {
            $this->validate($request, [
                'page_id' => 'required',
            ], $messages);
            $category_id = null;
            $page_id = $request->page_id;
        }

        $this->validate($request, [
            'order' => 'required|numeric',
        ], $messages);

        HeaderMenu::create([
            'category_id' => $category_id,
            'page_id' => $page_id,
            'order' => $request->order,
        ]);

        session()->flash('success', 'تم اضافة العنصر.');
        return redirect()->route('headermenus');
    }

    public function edit(Request $request, $id)
    {
        $headermenu = HeaderMenu::find($id);

        if ( count($headermenu) == 0 )
        {
            session()->flash('info', 'لا يوجد عنصر في القائمة بهذا الرقم.');
            return redirect()->route('headermenus');
        }

        return view('admin.headermenus.edit', [
            'headermenu' => $headermenu,
            'categories' => Category::all(),
            'pages' => Page::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $headermenu = HeaderMenu::find($id);

        if ( count($headermenu) == 0 )
        {
            session()->flash('info', 'لا يوجد عنصر في القائمة بهذا الرقم.');
            return redirect()->route('headermenus');
        }

        $messages = [
            'for.required' => 'يرجى تحديد ما تريد اضافته.',
            'category_id.required' => 'القسم مطلوب.',
            'page_id.required' => 'الصفحة مطلوبة.',
            'order.required' => 'الترتيب مطلوب.',
        ];

        $this->validate($request, [
            'for' => 'required',
        ], $messages);

        if ( $request->for == 'category' )
        {
            $this->validate($request, [
                'category_id' => 'required',
            ], $messages);
            $category_id = $request->category_id;
            $page_id = null;
        }
        else
        {
            $this->validate($request, [
                'page_id' => 'required',
            ], $messages);
            $category_id = null;
            $page_id = $request->page_id;
        }

        $this->validate($request, [
            'order' => 'required',
        ], $messages);

        $headermenu->update([
            'category_id' => $category_id,
            'page_id' => $page_id,
            'order' => $request->order,
        ]);

        session()->flash('success', 'تم تعديل العنصر.');
        return redirect()->route('headermenus');
    }

    public function destroy(Request $request, $id)
    {
        $headermenu = HeaderMenu::find($id);

        if ( count($headermenu) == 0 )
        {
            session()->flash('info', 'لا يوجد عنصر في القائمة بهذا الرقم.');
            return redirect()->route('headermenus');
        }

        $headermenu->delete();

        session()->flash('success', 'تم حذف العنصر.');
        return redirect()->route('headermenus');
    }
}
