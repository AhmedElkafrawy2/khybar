<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\User;
use Auth;
use App\ContactUs;
//use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
class UserController extends Controller
{
    public function __construct(){
        $this->middleware("api_auth");
    }
    
    // register new user
    public function UserSignUp(Request $request){
        $msg = array(
              1  => "الاسم مطلوب",
              2  => "البريد الالكترونى مطلوب",
              3  => "هذا البريد مستخدم من قبل من فضلك قم بادخال اختيار اخر",
              4  => "البريد الالكترونى غير صحيح",
              5  => "الرقم السرى مطلوب",
              6  => "الحد الادنى للرقم السرى ستة احرف",
              7  => "حدث خطأ من فضلك حاول لاحقا",
              8  => "تم ادخال البيانات بنجاح",
              9  => "رقم الجهاز مطلوب",
              10 => "رقم الهاتف مطلوب",
              11 => "رقم الهاتف غير صحيح",
              12 => "الصورة مطلوبة",
              13 => "امتداد الصورة مطلوب",
              14 => "امتداد الصورة يجب ان يكون png , jpg او jpeg",
              15 => "الصورة غير صحيحة",
        );
        $messages = array(
            "name.required"           => 1,
            "email.required"          => 2,
            "email.unique"            => 3,
            "email.email"             => 4,
            "password.required"       => 5,
            "password.min"            => 6,
            "device_reg_id.required"  => 9,
            "phone.required"          => 10,
            "phone.numeric"           => 11,
            "image.required"          => 12,
            "image_ext.required"      => 13,
            "image_ext.in"            => 14,
        );
        $validator = Validator::make($request->all(), [
            'name'           => 'required',
            'email'          => 'required|unique:users|email',
            'phone'          => 'required|numeric',
            'password'       => 'required|min:6',
            'device_reg_id'  => 'required',
            'image'          => 'required',
            'image_ext'      => 'required|in:png,jpg,jpeg',
        ] , $messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        
        // INSERT USER DATA
        $name           = $request->input("name");
        $email          = $request->input("email");
        $phone          = $request->input("phone");
        $password       = bcrypt($request->input("password"));
        $device_reg_id  = $request->input("device_reg_id");
        $image          = $request->input("image");
        $image_ext      = $request->input("image_ext");
        $path           = "storage/app/public/users/";
        $size           = (strlen($image) * 3 / 4) - substr_count(substr($image, -2), '=');
//        if ( base64_encode(base64_decode($image, true)) != $image){
//            return response()->json(["status" => false , "errNum" => 15 , 'msg' => $msg[15] ]);
//        }
        $path   = $this->saveImage($image, $image_ext, $path);
        if($path == ""){
            return response()->json(["status" => false , "errNum" => 7 , 'msg' => $msg[7] ]);
        }
        try {
             $image = \App\Image::create([
            'filename' => $path,
            'filetype' => $size,
            'filesize' => "image/".$image_ext,
             ]);
            $user = User::create([
                    "name"          => $name,
                    "email"         => $email,
                    "phone"         => $phone,
                    "password"      => $password,
                    'bio'           => $request->input('bio'),
                    'image_id'      => $image->id,
                    'device_reg_id' => $device_reg_id
            ]);
            return response()->json(["status" => true , 'errNum' => 0, 'msg' => $msg[8] , "user" => $this->get_user_data($user->id)]);          
        } catch (Exception $ex) {
            return response()->json(["status" => false , "errNum" => 7 , 'msg' => $msg[7] ]);
        }
    }

    // login user
    public function UserLogin(Request $request){
        $msg = array(
              1 => "البريد الالكترونى مطلوب",
              2 => "هذا البريد الالكترونى غير صحيح",
              3 => "البريد الالكترونى غير موجود",
              4 => "الرقم السرى مطلوب",
              5 => "تمت العملية بنجاح",
              6 => "خطأ فى اسم المستخدم او كلمة المرور",
              7 => "رقم الجهاز مطلوب",
        );
        $messages = array(
            "email.required"          => 1,
            "email.email"             => 2,
            "email.exists"            => 3,
            "password.required"       => 4,
            "device_reg_id.required"  => 7,
            
        );
        $validator = Validator::make($request->all(), [
            'email'          => 'required|email|exists:users',
            'password'       => 'required',
            'device_reg_id'  => 'required'
        ] , $messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        $email    = $request->input("email");
        $password = $request->input("password");
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user_id = Auth::user()->id;
            // update user reg id
            DB::table("users")
                        ->where("id" , $user_id)
                        ->update(["device_reg_id" => $request->input("device_reg_id")]);
            return response()->json(['status' => true , 'errNum' => 0, 'msg' => $msg[5] , "user" => $this->get_user_data($user_id)]);
        }else{
            return response()->json(['status' => false , 'errNum' => 6 , 'msg' => $msg[6]]);
        }
    }
    
    public function ForgetPassword(Request $request){
        
        $msg = array(
              1 => "البريد الالكترونى مطلوب",
              2 => "هذا البريد الالكترونى غير صحيح",
              3 => "البريد الالكترونى غير موجود",
              4 => "تم ارسال رابط تغيير الرقم السرى الى البريد الالكترونى الخاص بك",
              5 => "فشلت العملية برجاء المحاولة لاحقا",
        );
        $messages = array(
            "email.required"     => 1,
            "email.email"        => 2,
            "email.exists"       => 3,            
        );
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email|exists:users',
        ],$messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        $user_email = $request->input("email");
        $user       = DB::table("users")
                    ->where("email" , $user_email)
                    ->first();
        $forget_password = new ForgotPasswordController();
       
        $send_reset_link = $forget_password->sendResetLinkEmail($request,true);
         if($send_reset_link){
             return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[4]]);
         }else{
             return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5]]);
         }
    }
    
    // function contact us
    public function cotact_us(Request $request){
       $msg = array(
              1 => "البريد الالكترونى مطلوب",
              2 => "هذا البريد الالكترونى غير صحيح",
              3 => "رقم الهاتف مطلوب",
              4 => "رقم الهاتف غير صحيح",
              5 => "تمت العملية بنجاح",
              6 => "خطأ فى اسم المستخدم او كلمة المرور",
              7 => "برجاء ادخال رسالتك",
              8 => "الاسم مطلوب",
              9 => "رقم الهاتف يبدأ بـ 05 ، ويتكون من 10 ارقام.",
        );
        $messages = array(
            "email.required"     => 1,
            "email.email"        => 2,
            "phone.required"     => 3,
            "phone.numeric"      => 4,
            "message.required"   => 7,
            "name.required"      => 8,
            "phone.regex"        => 9,
        );
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'phone'     => 'required|numeric|regex:/(05)[0-9]{8}/',
            'message'   => 'required',
        ] , $messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        $name    = $request->input("name"); 
        $email   = $request->input("email");
        $phone   = $request->input("phone");
        $message = $request->input("message");
        try {
            // insert user message
            ContactUs::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'content' => $message,
            ]);
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[5]]);
        } catch (Exception $ex) {
            return response()->json(['status' => false, 'errNum' => 6, 'msg' => $msg[6]]);
        }
    }
    // function to return writter data
    public function get_writer_data(Request $request){
        
       $msg = array(
              1 => "رقم الكاتب مطلوب",
              2 => "رقم الكاتب يجب ان يحتوى على ارقام فقط",
              3 => "هذا الكاتب غير موجود",
              5 => "تمت العملية بنجاح",
              6 => "حدث خطأ برجاء المحاولة لاحقا",
        );
        $messages = array(
            "writer_id.required"     => 1,
            "writer_id.numeric"      => 2,
            "writer_id.exists"       => 3, 
        );
        $validator = Validator::make($request->all(), [
            'writer_id'  => 'required|numeric|exists:admins,id',
        ] , $messages);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
        }
        try{
           
            $writer_id = $request->input("writer_id");
            $writerData = DB::table("admins")
                            ->leftjoin("images" , "images.id" , "admins.image_id")
                            ->where("admins.id" , $writer_id)
                            ->select("admins.id AS writer_id" 
                                    , "admins.name AS writer_name"
                                    , DB::raw("CONCAT('". url("/") ."','/storage/app/public/writers/', images.filename) AS writer_image_url")
                                    )
                            ->first();
            $postsNumber = DB::table("posts")
                            ->where("writer_id" , $writer_id)
                            ->select("*")
                            ->get();
            $writerData->number_of_posts = count($postsNumber);

            // get writer posts
            $writerPosts = DB::table("posts")
                            ->where("writer_id" , $writer_id)
                            ->orderBy('posts.created_at' , 'desc')
                            ->select("posts.id AS post_id"
                                    ,"posts.type AS post_type"
                                    ,"posts.title AS post_title"
                                    ,"posts.content AS post_content"
                                    ,DB::raw("DATE(posts.created_at) AS post_create_date")
                                    ,"posts.views AS post_number_of_views"
                                    )
                            ->paginate(10);
            foreach ($writerPosts as $key => $value){
                
                mb_internal_encoding("UTF-8");
                
                                    mb_internal_encoding("UTF-8");
                $data  = trim(preg_replace("/\s|&nbsp;|&ldquo|&rdquo/", ' ', strip_tags($value->post_content)));
                $value->post_content = $data;
                // get brief content
                $value->content_brief =  mb_substr($data , 0 ,  (floor(strlen(strip_tags($data)) / 4))  );
               
                // get post type
                $post_type = $value->post_type;
                if($post_type == "1" || $post_type == 1){
                    $image_path = "news";
                }elseif($post_type == "2" || $post_type == 2){
                    $image_path = "essays";
                }else{
                    $image_path = "news";
                }
                // get post image id
                $image_id = DB::table("posts")
                            ->where("id" , $value->post_id)
                            ->select("image_id")
                            ->first();
                $image_url = DB::table("images")
                                ->where("id" , $image_id->image_id)
                                ->select(DB::raw("CONCAT('". url("/") ."','/storage/app/public/". $image_path ."/', images.filename) AS post_image_url"))
                                ->first();
                $value->post_image_url = $image_url->post_image_url;
            }
            if($request->input("page") == "1" ||$request->input("page") == 1 || $request->input("page") == null || $request->input("page") == ""){
                return response()->json(['status' => true, 'errNum' => 0 , "msg" => $msg[5] , "writer_data" => $writerData ,"writer_posts" => $writerPosts ]);
            }else{
                return response()->json(['status' => true, 'errNum' => 0 , "msg" => $msg[5] ,"writer_posts" => $writerPosts ]);
            }
            
        } catch (Exception $ex) {
            return response()->json(['status' => false, 'errNum' => 6 , "msg" => $msg[6]]);
        }
    }
    
    // function to return user info
    private function get_user_data($user){
        $userData = DB::table("users")
                    ->leftjoin('images' , "users.image_id" , "images.id")
                    ->where("users.id" , $user)
                    ->select("users.id AS user_id" 
                            , "users.name" 
                            , "users.email" 
                            , "users.phone"
                            ,DB::raw("CONCAT('". url("/") ."','/storage/app/public/users/', images.filename) AS image_url")
                            ,"users.created_at" 
                            , "users.updated_at")
                    ->first();
        if($userData->image_url == null){
            $userData->image_url = url("/") ."/storage/app/public/users/default.png";
        }
        return $userData;
    }
    // function to save image
    protected function saveImage($data, $image_ext, $path){

            if(!empty($data)){
            $data = str_replace('\n', "", $data);
            $data = base64_decode($data);

            $im   = imagecreatefromstring($data);
            
            if ($im !== false) {
                    $name = str_random(40).'.'.$image_ext;
                    if ($image_ext == "png"){
                        imagepng($im, $path . $name, 9);
                    }else{
                        imagejpeg($im, $path . $name, 100);
                    }
                    return $name;
            } else {
                    return "";
            }
            }else{
                return "";
            }
    }
}
