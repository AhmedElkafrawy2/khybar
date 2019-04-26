<?php

namespace App\Http\Controllers;

use App\BreakingNew;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Apis\PushNotification;
class BreakingNewController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.breakingnews.index', [
            'breakingnews' => BreakingNew::all()
        ]);
    }

    public function create()
    {
        return view('admin.breakingnews.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'العنوان مطلوب.',
        ];

        $this->validate($request, [
            'title' => 'required',
        ], $messages);

        try{
             $insert_post = BreakingNew::create([
                            'title' => $request->title,
                            ]);
            if($insert_post){
                // send notification to the user
                
                $push_notif_title = "خبر عاجل";
                $post_id          = $insert_post->id;
                $post_title       = $insert_post->title;
                
                $notif_data = array();
                $notif_data['title']   = $push_notif_title;
                $notif_data['body']    = $post_title;
                $notif_data['id']      = $post_id;

                // get users device reg token
                $all_users_token = DB::table("users")
                                ->select("device_reg_id")
                                ->get();
                if(count($all_users_token) > 0){
                    foreach ($all_users_token as $key => $value){
                        if($value->device_reg_id != null){
                            $push = new PushNotification();
                            $push_notif = $push->send($value->device_reg_id,$notif_data);
                        }
                    }
                }
            }
            session()->flash('success', 'تم اضافة الخبر.');
            return redirect()->route('breakingnews');
        } catch (Exception $ex) {
            session()->flash('fail', 'لم يتم اضافة الخبر برجاء المحاولة لاحقا');
            return redirect()->route('breakingnews');
        }
    }

    public function edit(Request $request, $id)
    {
        $breakingnew = BreakingNew::find($id);

        if ( count($breakingnew) == 0 )
        {
            session()->flash('info', 'لا يوجد خبر بهذا الرقم.');
            return redirect()->route('breakingnews');
        }

        return view('admin.breakingnews.edit', [
            'breakingnew' => $breakingnew
        ]);
    }

    public function update(Request $request, $id)
    {
        $breakingnew = BreakingNew::find($id);

        if ( count($breakingnew) == 0 )
        {
            session()->flash('info', 'لا يوجد خبر بهذا الرقم.');
            return redirect()->route('breakingnews');
        }

        $messages = [
            'title.required' => 'الاسم مطلوب.',
        ];

        $this->validate($request, [
            'title' => 'required',
        ], $messages);

        $breakingnew->update([
            'title' => $request->title,
        ]);

        session()->flash('success', 'تم تعديل الخبر.');
        return redirect()->route('breakingnews');
    }

    public function destroy(Request $request, $id)
    {
        $breakingnew = BreakingNew::find($id);

        if ( count($breakingnew) == 0 )
        {
            session()->flash('info', 'لا يوجد خبر بهذا الرقم.');
            return redirect()->route('breakingnews');
        }

        $breakingnew->delete();

        session()->flash('success', 'تم حذف الخبر.');
        return redirect()->route('breakingnews');
    }
}
