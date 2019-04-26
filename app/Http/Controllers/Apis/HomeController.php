<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Post;
class HomeController extends Controller
{
    public function __construct(){
        $this->middleware("api_auth");
    }
    
    // return main screen data
    public function get_main_screen_data(Request $request){
        
        $msg = array(
              1  => "تمت العملية بنجاح",
              2  => "حدث خطأ برجاء المحاولة لاحقا",
              3  => "نوع الفرز مطلوب",
              4  => "يجب ان يكون نوع الفرز 0,1,2",
        );
        $messages = array(
            "sort_type.required"   => 3,
            "sort_type.in"         => 4,
        );
        $validator = Validator::make($request->all(), [
            'sort_type'   => 'required|in:0,1,2',
        ] , $messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        $base_url = url("/");
        $sort_type = $request->input("sort_type");
        if($sort_type == "0" || $sort_type ==  0){
            $sort_by = "created_at";
            $query = "posts." . $sort_by;
        }elseif($sort_type == "1" || $sort_type ==  1){
            $sort_by = "views";
            $query = "posts." . $sort_by;
        }else{
            $sort_by = "comments_number";
            $query = "posts." . $sort_by;
        }
        try 
        {
            // khybar slider news
            $date = date("Y/m/d");
            $slider_news = DB::table("posts")
                            ->join("images" , "images.id" , "posts.image_id")
                            ->where('posts.slide', 1)
                            ->where('posts.slider_date' , ">=" , $date)
                            ->orderBy('posts.created_at', 'desc')
                            ->take(10)
                            ->select("posts.id AS news_id" 
                                    , "posts.title AS news_title"
                                    , "posts.type AS post_type", "posts.slug" 
                                    , DB::raw("CONCAT('". $base_url ."','/storage/app/public/news/', images.filename) AS news_image_url"))
                            ->get();

            $slider_new_ids = array();
            $slider_news_arr = json_decode(json_encode($slider_news), true);
            foreach ($slider_news_arr as $key => $value){
                $slider_new_ids[] = $value["news_id"];
            }
            // khybar news
            $khybar_news = DB::table("posts")
                            ->join("images" , "images.id" , "posts.image_id")
                            ->leftjoin("categories" , "categories.id" , "posts.category_id")
                            ->where('posts.type', 1)
                            ->whereNotIn('posts.id', $slider_new_ids)
                            ->orderBy($query, 'desc')
                            ->select("posts.id AS news_id" 
                                    , "posts.title AS news_title" 
                                    , "posts.slug AS news_slug" 
                                    , "posts.type AS news_type" 
                                    , DB::raw("DATE(posts.created_at) AS news_create_date") 
                                    , DB::raw("CONCAT('". $base_url ."','/storage/app/public/news/', images.filename) AS news_image_url") 
                                    ,"categories.id AS category_id"
                                    , "categories.name AS category_name" , "posts.views AS news_views")
                            ->paginate(10);
            if($request->input("page") == "1" || $request->input("page") == 1 ||$request->input("page") == "" || $request->input("page") == null){
                return response()->json(['status' => true , 'errNum' => 0, 'msg' => $msg[1] , "slider_news" => $slider_news , "khybar_news" => $khybar_news]);
            }else{
                return response()->json(['status' => true , 'errNum' => 0, 'msg' => $msg[1] , "khybar_news" => $khybar_news]);
            }
            //return response()->json(['status' => true , 'errNum' => 0, 'msg' => $msg[1] , "slider_news" => $slider_news , "khybar_news" => $khybar_news]);
        }
        catch (Exception $ex) {
            return response()->json(['status' => false , 'errNum' => 2, 'msg' => $msg[2]]);
        } 
    }
    
    // function to return atrgory && pages list
    public function get_category_pages(Request $request){
        $msg = array(
            1  => "تمت العملية بنجاح",
            2  => "حدث خطأ برجاء المحاولة لاحقا",
        );
        try {
            $category = DB::table("categories")
                            ->select("categories.id AS id" 
                                    , "categories.name AS name" 
                                    , "categories.slug AS slug" 
                                    , DB::raw("CONCAT('1') AS type")
                                    )
                            ->get();
            $pages = DB::table("pages")
                        ->where("id" , "!=" , "1")
                        ->select("pages.id AS id" 
                                , "pages.title AS name" 
                                , "pages.slug AS slug", 
                                DB::raw("CONCAT('2') AS type")
                                )
                        ->get();
            $pages_categories = array();
            foreach ($category as $cat => $value){
                $pages_categories[]= $value;
            }
            foreach ($pages as $page => $value){
                $pages_categories[]= $value;
            }
            
            foreach($pages_categories as $key => $value){
                if($value->id == 3 && $value->type == 2){
                     $value->id = 0; 
                }
            }
            
            return response()->json(['status' => true , 'errNum' => 0, 'msg' => $msg[1] , "categories_pages" => $pages_categories]);
        } catch (Exception $ex) {
            return response()->json(['status' => false , 'errNum' => 2, 'msg' => $msg[2]]);
        }
    }
    // public function user search
    public function user_search(Request $request){
        $msg = array(
              1  => "تمت العملية بنجاح",
              2  => "حدث خطأ برجاء المحاولة لاحقا",
              3  => "برجاء ادخال كلمات البحث"
        );
        $messages = array(
            "query.required" => 3,
        );
        $validator = Validator::make($request->all(), [
            'query'   => 'required',
        ] , $messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        try {
            $query  = $request->input("query");
            $result = DB::table("posts")
                    ->leftjoin("categories" , "categories.id" , "posts.category_id")
                    ->join("images" , "images.id" , "posts.image_id")
                    ->where("title" , "like" , "%" . $query . "%")
                    ->orWhere("content" , "like" , "%" . $query . "%")
                    ->orWhere("description" , "like" , "%" . $query . "%")
                    ->orderBy("posts.created_at", 'desc')
                    ->select("posts.id AS news_id"
                            ,"posts.type AS news_type"
                            ,"posts.title AS news_title"
                            ,"posts.slug AS news_slug"
                            ,"posts.views AS news_views"
                            ,DB::raw("DATE(posts.created_at) AS news_create_date")
                            ,"categories.name AS category_name"
                            ,"categories.id AS category_id"
                            )
                    ->paginate(10);
            foreach ($result as $key => $value){
                if($value->news_type == "1" || $value->news_type == 1){
                    $image_path = "news";
                }else{
                    $image_path = "essays";
                }
                $image_id = DB::table("posts")
                            ->where("id" , $value->news_id)
                            ->select("image_id AS post_image_id")
                            ->first();
                $image_name = DB::table("images")
                                ->where("id" , $image_id->post_image_id)
                                ->select(DB::raw("CONCAT('". url("/") ."','/storage/app/public/". $image_path ."/', images.filename) AS post_image_url"))
                                ->first();
                $value->news_image_url = $image_name->post_image_url;
            }
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[1] , "khybar_news" => $result]);
        } catch (Exception $ex) {
            return response()->json(['status' => true, 'errNum' => 2, 'msg' => $msg[2]]);
        }
    }
}
