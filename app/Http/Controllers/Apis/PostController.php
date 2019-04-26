<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Comment;
class PostController extends Controller
{
    public function __construct(){
        $this->middleware("api_auth");
    }
    
    public function get_category_posts_list(Request $request){
        $msg = array(
              1  => "تمت العملية بنجاح",
              2  => "حدث خطأ برجاء المحاولة لاحقا",
              3  => "الرقم مطلوب",
              4  => "النوع مطلوب",
              5  => "النوع يجب ان يكون 1,2",
              6  => "الرقم يجب ان يكون رقم",
              7  => "هذا الرقم غير موجود",
        );
        $messages = array(
            "id.required"    => 3,
            "id.numeric"     => 6,
            "id.exists"      => 7,
            "type.required"  => 4,
            "type.in"        => 5,
        );
        $rules ['type'] = 'required|in:1,2';

        
        $type = $request->input("type");
        if($type == "1" || $type == 1){
            $rules["id"] = 'required|numeric|exists:categories' ;
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }

        $id   = $request->input("id");
        $base_url = url("/");
        try{
            // return list of posts
            if($type == "1" || $type == 1){
                $posts = DB::table("posts")
                            ->join("images" , "images.id" , "posts.image_id")
                            ->where("posts.category_id" , $id)
                            ->join("categories" , "categories.id" , "posts.category_id")
                            ->where("posts.type" , "1")
                            ->select("categories.name AS category_name"
                                    ,"posts.id AS post_id" 
                                    , "posts.type AS post_type" 
                                    , "posts.title AS post_title" 
                                    , DB::raw("DATE(posts.created_at) AS post_create_date") 
                                    , "posts.views AS post_views_number" 
                                    , DB::raw("CONCAT('". $base_url ."','/storage/app/public/news/', images.filename) AS post_image_url")
                                    ,DB::raw("CONCAT('') AS writer_name")
                                    )
                            ->orderBy('posts.created_at' , 'desc')
                            ->paginate(10);
                
                foreach ($posts as $key => $value){
                    
                    $get_post_content = DB::table("posts")
                                        ->where("id" , $value->post_id)
                                        ->select("content AS post_content")
                                        ->first();
                    mb_internal_encoding("UTF-8");
                    $data  = trim(preg_replace("/\s|&nbsp;|&ldquo|&rdquo/", ' ', strip_tags($get_post_content->post_content)));
                    // get brief content
                    $value->content_brief =  mb_substr($data , 0 ,  (floor(strlen(strip_tags($data)) / 4))  );
                }
            }else{
                $posts = DB::table("posts")
                            ->join("images" , "images.id" , "posts.image_id")
                            ->join("admins" , "admins.id" , "posts.writer_id")
                            ->where("posts.type" , "2")
                            ->select(DB::raw("CONCAT('') AS category_name")
                                    ,"posts.id AS post_id" 
                                    , "posts.type AS post_type" 
                                    , "posts.title AS post_title" 
                                    , DB::raw("DATE(posts.created_at) AS post_create_date") 
                                    , "posts.views AS post_views_number" 
                                    , DB::raw("CONCAT('". $base_url ."','/storage/app/public/essays/', images.filename) AS post_image_url")
                                    ,DB::raw("CONCAT('') AS content_brief")
                                    ,"admins.name AS writer_name"
                                    )
                            ->orderBy('posts.created_at' , 'desc')
                            ->paginate(10); 
            }
            return response()->json(['status' => true , 'errNum'  => 0, 'msg' => $msg[1] , "posts" => $posts]);
        } catch (Exception $ex) {
            return response()->json(['status' => false , 'errNum' => 2, 'msg' => $msg[2]]);
        }

    }
    
    public function get_list_of_writers(){
        $msg = array(
            1 => "تم استرجاع البيانات بنجاح"
        );
        $staffer = DB::table("staffer")
                    ->join("images" , "images.id" , "staffer.image_id")
                    ->select("staffer.id"
                            ,"staffer.name"
                            ,"staffer.job_title"
                            ,DB::raw("CONCAT('". url("/") ."','/storage/app/public/staffer/', images.filename) AS image_url"))
                    ->get();
        return response()->json(['status' => true , 'errNum'  => 0, 'msg' => $msg[1] , "staffer" => $staffer]);
    }
    
    // function to get post details
    public function get_post_details(Request $request){
        $msg = array(
              1  => "تمت العملية بنجاح",
              2  => "حدث خطأ برجاء المحاولة لاحقا",
              3  => "الرقم مطلوب",
              4  => "الرقم يجب ان يحتوى على ارقام فقط",
              5  => "هذا الرقم غير موجود",
        );
        $messages = array(
            "id.required"   => 3,
            "id.numeric"    => 4,
            "id.exists"     => 5,
        );
        $validator = Validator::make($request->all(), [
            'id'     => 'required|numeric|exists:posts',
        ] , $messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        $base_url = url("/");
        $id   = $request->input("id");
        
        // get the post type from post_id
        $type = DB::table("posts")
                    ->where("id" , $id)
                    ->select("type")
                    ->first();
        
        if($type->type == "1" || $type->type == 1){
            $image_path = "news";
        }elseif($type->type = "2" || $type->type = "2"){
            $image_path = "essays";
        }else{
            $image_path = "news";
        }
        try{
            $post_details = DB::table("posts")
                            ->join("images" , "images.id" , "posts.image_id")
                            ->join("admins" , "admins.id" , "posts.writer_id")
                            ->where("posts.id" , $id)
//                            ->where("posts.type" , $type)
                            ->select("posts.id AS post_id" , "posts.type AS post_type" , "posts.title AS post_title" 
                                    , "posts.content AS post_content" , "posts.views AS post_views_number" 
                                    ,"posts.created_at AS post_create_date" 
                                    , "posts.comments AS allow_comment" 
                                    , "posts.post_source AS post_source" 
                                    ,DB::raw("CONCAT('". $base_url ."','/storage/app/public/". $image_path ."/', images.filename) AS post_image_url")
                                    ,DB::raw("CONCAT('". $base_url ."','/". $image_path ."/', posts.slug) AS post_shared_link")
                                    , "admins.id AS post_writer_id" 
                                    , "admins.name AS post_writer_name" 
                                    )
                            ->first();

            // get admin image id
            $writer_image_id = DB::table("admins")
                                ->where("id" , $post_details->post_writer_id)
                                ->select("image_id")
                                ->first();
            if($writer_image_id->image_id != null){
                $writer_image = DB::table("images")
                                    ->where("id" , $writer_image_id->image_id)
                                    ->select("filename")
                                    ->first();
                $post_details->post_writer_image_url = $base_url . "/storage/app/public/writers/" . $writer_image->filename;  
            }else{
                $post_details->post_writer_image_url = "";
            }
            // get writer number of articles
            $Writer_num_of_aticles = DB::table("posts")
                                        ->where("writer_id" , $post_details->post_writer_id)
                                        ->select()
                                        ->get();
            $post_details->writer_number_of_posts = count($Writer_num_of_aticles);                            
            // get post number of comments
            $comments = DB::table("comments")
                            ->where("post_id" , $post_details->post_id)
                            ->where("approved" , 1)
                            ->select()
                            ->get();
            $post_details->post_comments_number = count($comments);
            
            // get images inside post content
            preg_match_all( '@src="([^"]+)"@' , $post_details->post_content, $match );
            $src = array_pop($match);
            $img = [];
            mb_internal_encoding("UTF-8");
            foreach($src as $key ){
                $img[]   = url("/") . $key;
            }
            $post_details->post_images  = $img;
            

            $post_details->post_content = preg_replace("/<img[^>]+\>/i", "", $post_details->post_content);
            $post_details->post_content = preg_replace("/<p[^>]*><\\/p[^>]*>/", "", $post_details->post_content);
            $post_details->post_content = preg_replace("~[\r\n]+~", "", $post_details->post_content);
            
            
            // increment post views number
            DB::table("posts")
                        ->where("id" , $id)
                        ->increment('views', 1);
            return response()->json(['status' => true , 'errNum'  => 0, 'msg' => $msg[1] , "post_details" => $post_details]);
        } catch (Exception $ex) {
            return response()->json(['status' => false , 'errNum'  => 2, 'msg' => $msg[2]]);
        }     
    }
    
    //function to get post comments
    public function get_post_comments(Request $request){
        $msg = array(
              1  => "تمت العملية بنجاح",
              2  => "حدث خطأ برجاء المحاولة لاحقا",
              3  => "الرقم مطلوب",
              4  => "الرقم يجب ان يحتوى على ارقام فقط",
              5  => "هذا الرقم غير موجود",
        );
        $messages = array(
            "id.required"   => 3,
            "id.numeric"    => 4,
            "id.exists"     => 5,
        );
        $validator = Validator::make($request->all(), [
            'id'     => 'required|numeric|exists:posts',
        ] , $messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        $post_id = $request->input("id");
        try {
            $comments = DB::table("comments")
                        ->where("comments.post_id" , $post_id)
                        ->where("comments.approved" , 1)
                        ->select("comments.user_id AS user_id" 
                                , "comments.name AS user_name" 
                                , "comments.id AS comment_id" 
                                , "comments.content AS comment_text" 
                                , "comments.created_at AS comment_create_date")
                        ->paginate(10);
            foreach($comments as $comment){
                if($comment->user_id == 0 || $comment->user_id == "0"){
                    $comment->image_url = url("/")  . "/storage/app/public/users/default.png";
                }else{
                    
                    $image = DB::table('users')
                                ->where("users.id" , $comment->user_id)
                                ->join("images" , "images.id" , "users.image_id")
                                ->select(DB::raw("CONCAT('". url("/") ."','/storage/app/public/users/', images.filename) AS image_url"))
                                ->first();
                    if($image){
                        $comment->image_url = $image->image_url;
                    }else{
                        $comment->image_url = url("/")  . "/storage/app/public/users/default.png";
                    }
                    
                }
            }
            return response()->json(['status' => true , 'errNum'  => 0, 'msg' => $msg[1] , "post_comments" => $comments]);
        } catch (Exception $ex) {
            return response()->json(['status' => false , 'errNum'  => 2, 'msg' => $msg[2]]);
        }
    }
    
    // insert user comment
    public function insert_comment(Request $request){
        $msg = array(
              1  => "تمت العملية بنجاح",
              2  => "حدث خطأ برجاء المحاولة لاحقا",
              3  => "رقم المستخدم مطلوب",
              4  => "رقم المستخدم يجب ان يحتوى على ارقام فقط",
              5  => "هذا المستخدم غير موجود",
              6  => "الاسم مطلوب",
              7  => "التعليق مطلوب",
              8  => "رقم المنشور مطلوب",
              9  => "رقم المنشور يجب ان يحتوى على ارقام فقط",
              10  => "هذا المنشور غير موجود",
        );
        $messages = array(
            "user_id.required"  => 3,
            "user_id.numeric"   => 4,
            "user_id.exists"    => 5,
            "name.required"     => 6,
            "comment.required"  => 7,
            "post_id.required"  => 8,
            "post_id.numeric"   => 9,
            "post_id.exists"    => 10,
        );
        $rules = [
            'post_id'  => 'required|numeric|exists:posts,id',
            'name'     => 'required',
            'comment'  => 'required',
        ];
        if($request->input('user_id') == "0" || $request->input('user_id') == 0){
            $rules['user_id'] = 'required|numeric';
        }else{
            $rules['user_id'] = 'required|numeric|exists:users,id';
        }
        $validator = Validator::make($request->all(), $rules , $messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        
        $user_id = $request->input("user_id");
        $post_id = $request->input("post_id");
        $name    = $request->input("name");
        $comment = $request->input("comment");

        try {    
            if($user_id == "0" || $user_id == 0){
                $approved = 0;
            }else{
                $approved = 1;
            }
            Comment::create([
                'content'  => $comment,
                'user_id'  => $user_id,
                'post_id'  => $post_id,
                'approved' => $approved,
                'name'     => $name
            ]);
            if($user_id != "0" && $user_id != 0){
                DB::table("posts")
                        ->where("id" , $post_id)
                        ->increment('comments_number', 1);
            }

            $comments_num = DB::table("comments")
                                ->where("post_id" , $post_id)
                                ->where("approved" , 1)
                                ->get();
            
            return response()->json(['status' => true , 'errNum'  => 0, 'msg' => $msg[1] , "post_comments_number" => count($comments_num)]);
        } catch (Exception $ex) {
            return response()->json(['status' => false , 'errNum'  => 2, 'msg' => $msg[2]]);
        }
    }
}

