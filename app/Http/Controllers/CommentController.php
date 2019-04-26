<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use DB;
use Auth;
class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['store']]);
    }

    public function index()
    {
        return view('admin.comments.index', [
            'show' => 'unread',
            'comments' => Comment::with('post')->where('reviewed', 0)->paginate(25),
        ]);
    }

    public function all()
    {
        return view('admin.comments.index', [
            'show' => 'all',
            'comments' => Comment::with('post')->paginate(25),
        ]);
    }

    public function show($id)
    {
        $comment = Comment::find($id);
        if ( count($comment) == 0 )
        {
            session()->flash('info', 'لا يوجد تعليق بهذا الرقم.');
            return redirect()->route('comments');
        }
        $comment->reviewed();

        return view('admin.comments.show', [
            'comment' => $comment
        ]);
    }

    public function review($id)
    {
        $comment = Comment::find($id);
        if ( count($comment) == 0 )
        {
            session()->flash('info', 'لا يوجد تعليق بهذا الرقم.');
            return redirect()->route('comments');
        }
        $comment->reviewed();

        session()->flash('success', 'تم تعليمه كمقروء.');
        return redirect()->route('comments');
    }

    public function store(Request $request)
    {
        $messages = [
            'post_id.required' => 'لم نجد المنشور.',
            'content.required' => 'التعليق مطلوب.',
            'name.required'    => 'الاسم مطلوب',
        ];
        $rules = [
            'post_id' => 'required',
            'content' => 'required',
        ];
        
        if(Auth::user()){
            $name      = Auth::user()->name;
            $id        = Auth::user()->id;
            $approved  = 1;
        }else{
            $rules['name'] = 'required';
            $name      = $request->input("name");
            $id        = 0;
            $approved  = 0;
        }
        $this->validate($request, $rules , $messages);
        Comment::create([
            'content'  => $request->content,
            'user_id'  => $id,
            'name'     => $name,
            'approved' => $approved,
            'post_id'  => $request->post_id,
        ]);
        if(Auth::user()){
            DB::table("posts")
                ->where("id" , $request->post_id)
                ->increment('comments_number', 1);
            session()->flash('success', 'لقد استلمنا تعليقك.');
        }else{
            session()->flash('success', 'سوف يتم عرض التعليق بعد مراجعتة من قبل الادارة');
        }
        return back();
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if ( count($comment) == 0 )
        {
            session()->flash('info', 'لا يوجد تعليق بهذا الرقم.');
            return redirect()->route('comments');
        }
        if($comment->approved == 1){
            DB::table("posts")
                ->where("id" , $comment->post_id)
                ->decrement('comments_number' , 1);
        }
        $comment->delete();
        session()->flash('success', 'تم حذف التعليق.');
        return redirect()->route('comments');
    }
    
    public function activate($id)
    {
        $comment = Comment::find($id);
        if ( count($comment) == 0 )
        {
            session()->flash('info', 'لا يوجد تعليق بهذا الرقم.');
            return redirect()->route('comments');
        }
        DB::table("posts")
                ->where("id" , $comment->post_id)
                ->increment('comments_number' , 1);
        $comment->activate();
        session()->flash('success', 'تم التفعيل بنجاح');
        return redirect()->route('comments');
    }
    public function deactivate($id)
    {
        $comment = Comment::find($id);
        if ( count($comment) == 0 )
        {
            session()->flash('info', 'لا يوجد تعليق بهذا الرقم.');
            return redirect()->route('comments');
        }
        DB::table("posts")
                ->where("id" , $comment->post_id)
                ->decrement('comments_number' , 1);
        $comment->deactivate();
        session()->flash('success', 'تم الغاء التفعيل بنجاح');
        return redirect()->route('comments');
    }
}
