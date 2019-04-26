<?php

namespace App\Http\Controllers;

use App\SocialLink;
use App\HeaderMenu;
use App\FooterMenu;
use App\BreakingNew;
use App\Banner;
use App\Setting;
use App\Post;
use App\Staffer;
use App\Referendum;
use App\Category;
use App\Page;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class IndexController extends Controller
{
    public function __construct()
    {
        $sociallinks = SocialLink::all();
        $headermenus = HeaderMenu::orderBy('order', 'asc')->get();
        $footermenus = FooterMenu::orderBy('order', 'asc')->get();
        $breakingnews = BreakingNew::all();
        $lastnews = Post::where('type', 1)->orderBy('created_at', 'desc')->take(10)->get();
        $lastessays = Post::where('type', 2)->orderBy('created_at', 'desc')->take(7)->get();
        $mostviewed = Post::orderBy('views', 'desc')->take(5)->get();
        $mostcommented = Post::with('comments')->get()->sortByDesc(function($mostcommented)
        {
            return $mostcommented->comments()->count();
        });
        $slidebarslides = Post::where('category_id', Setting::find(1)->sidebar_slider_category_id)->orderBy('created_at', 'desc')->take(3)->get();
        $referendum = Referendum::find(1);
        if ( !Setting::find(1)->random_banners )
        {
            $rightbanners = Banner::where('position', 1)->orderBy('created_at', 'desc')->take(3)->get();
            $leftbanners = Banner::where('position', 2)->orderBy('created_at', 'desc')->take(2)->get();
        } else {
            $rightbanners = Banner::where('position', 1)-inRandomOrder()->take(3)->get();
            $leftbanners = Banner::where('position', 2)-inRandomOrder()->take(2)->get();
        }

        View::share([
            'sociallinks' => $sociallinks,

            'headermenus' => $headermenus,
            'footermenus' => $footermenus,

            'breakingnews' => $breakingnews,
            'lastnews' => $lastnews,

            'rightbanners' => $rightbanners,
            'leftbanners' => $leftbanners,

            'lastessays' => $lastessays,
            'mostviewed' => $mostviewed,
            'mostcommented' => $mostcommented,
            'slidebarslides' => $slidebarslides,
            'referendum' => $referendum,
        ]);
    }

    public function index()
    {
        $date = date("Y/m/d");
        return view('index', [
            'news'   => Post::where('type', 1)->orderBy('created_at', 'desc')->paginate(12),
            'slides' => Post::where('type', 1)->where('slide', 1)->where('slider_date' , ">=" , $date)->orderBy('created_at', 'desc')->take(10)->get(),
        ]);
    }
    
    public function search(Request $request)
    {
        $messages = [
            'word.required' => 'ادخل كلمة للبحث',
        ];
        
        $this->validate($request, [
            'word' => 'required',
        ], $messages);
        
        return view('search', [
            'word' => $request->word,
            'news' => Post::where('title', 'LIKE', '%' . $request->word . '%')->orWhere('description', 'LIKE', '%' . $request->word . '%')->orWhere('content', 'LIKE', '%' . $request->word . '%')->orderBy('created_at', 'desc')->paginate(12),
        ]);
    }

    public function showNews($slug)
    {
        $new = Post::where('type', 1)->where('slug', $slug)->first();
        if ( count( $new ) == 0 )
        {
            session('info', 'لا يوجد خبر بهذا الرابط.');
            return redirect()->route('index');
        }
        $new->update([
            'views' => $new->views++,
        ]);

        return view('news', [
            'new' => $new,
        ]);
    }

    public function showEssays()
    {
        $page = Page::find(2);
        if ( !$page->content )
        {
            session('info', 'هذه الصفحة موقوفة حاليا.');
            return redirect()->route('index');
        }

        return view('essays', [
            'essays' => Post::where('type', 2)->orderBy('created_at', 'asc')->paginate(12),
            'page' => $page,
        ]);
    }

    public function showEssay($slug)
    {
        $essay = Post::where('type', 2)->where('slug', $slug)->first();
        if ( count( $essay ) == 0 )
        {
            session('info', 'لا يوجد مقال بهذا الرابط.');
            return redirect()->route('index');
        }
        $essay->update([
            'views' => $essay->views++,
        ]);


        return view('essay', [
            'essay' => $essay,
        ]);
    }

    public function showCategory($slug, $currentPage = 1)
    {
        $category = Category::where('slug', $slug)->first();
        if ( count( $category ) == 0 )
        {
            session('info', 'لا يوجد قسم بهذا الرابط.');
            return redirect()->route('index');
        }

        return view('category', [
            'category' => $category,
            'category_posts' => $category->latest_posts()->paginate(12),
        ]);
    }

    public function showPage($slug)
    {
        if ( $slug == 'essays' )
        {
            return redirect()->route('show.essays');
        }
        if ( $slug == 'contact-us' )
        {
            return redirect()->route('contactuses.create');
        }
        if ( $slug == 'altahrir' )
        {
            return redirect()->route('show.altahrir');
        }
        $page = Page::where('slug', $slug)->first();
        if ( count( $page ) == 0 )
        {
            session('info', 'لا يوجد صفحة بهذا الرابط.');
            return redirect()->route('index');
        }

        return view('page', [
            'page' => $page,
        ]);
    }

    public function showstuff(){
        
        $page = Page::find(3);
        if ( !$page->content )
        {
            session('info', 'هذه الصفحة موقوفة حاليا.');
            return redirect()->route('index');
        }

        return view('stuff', [
            'staffer' => Staffer::orderBy('created_at', 'asc')->paginate(12),
            'page'    => $page,
        ]);
    }
    public function createContactUs()
    {
        $page = Page::find(1);
        if ( !$page->content )
        {
            session('info', 'هذه الصفحة موقوفة حاليا.');
            return redirect()->route('index');
        }

        return view('contactus', [
            'page' => $page,
        ]);
    }

    public function showWriter($id)
    {
        // if ( $id == 1 )
        // {
        //     session('info', 'لا يوجد كاتب بهذا الرقم.');
        //     return redirect()->route('index');
        // }
        $writer = Admin::find($id);
        if ( count( $writer ) == 0 )
        {
            session('info', 'لا يوجد كاتب بهذا الرقم.');
            return redirect()->route('index');
        }

        return view('writer', [
            'admin_posts' => $writer->posts()->paginate(12),
            'writer' => $writer
        ]);
    }
}
