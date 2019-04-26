<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class TinyMCEController extends Controller
{
    public function uploadPostsImage(Request $request)
    {
        // Allowed origins to upload images
        // $accepted_origins = array("http://khaybarnews.com");

        if ( App::environment('local') ){
            $imageFolder = 'storage/posts-images/';
        }
        elseif ( App::environment('server') ){
            $imageFolder = 'storage/app/public/posts-images/';
        }

        $temp = current($_FILES);

        //if(isset($_SERVER['HTTP_ORIGIN'])){
            // Same-origin requests won't set an origin. If the origin is set, it must be valid.
            //if(in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)){
                //header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);

                if(is_uploaded_file($temp['tmp_name'])){
                    // Sanitize input
                    if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
                        header("HTTP/1.1 400 Invalid file name.");
                        return;
                    }
                    // Verify extension
                    if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png", "jpeg"))){
                        header("HTTP/1.1 400 Invalid extension.");
                        return;
                    }

                    $array = explode('.', $temp["name"]);
                    $newfile = $array[0]."_".time().".".$array[1];

                    $filetowrite = $imageFolder . $newfile;

                    move_uploaded_file($temp['tmp_name'], $filetowrite);
                    // Respond to the successful upload with JSON.
                    return json_encode(['location' => '/' . $filetowrite]);
                }
            //}
            //else{
                header("HTTP/1.1 403 Origin Denied");
                //die(json_encode(array('message' => 'orgin refused.')));
            //}
        //}

        //else {
            // Notify editor that the upload failed
            //header("HTTP/1.1 500 Internal Server Error");
            //die(json_encode(array('message' => 'orgin not set.')));
        //}
    }
    
    public function uploadPostsImageAll(Request $request){
        
        if ( App::environment('local') ){
            $imageFolder = 'storage/posts-images/';
        }
        elseif ( App::environment('server') ){
            $imageFolder = 'storage/app/public/posts-images/';
        }
        $number = $request->input("number");
        $uploadedImages = [];
        if($request->hasFile("0")){
            
            for($i = 0; $i <= $number ; $i++){
                $request->$i->store('posts-images', 'public');
                $name =  $request->$i->hashName();
                $filetowrite = url("/") . "/" .$imageFolder . $name;
                $uploadedImages[] =  $filetowrite;
  
           }
           
           return response()->json([$uploadedImages]);
        }  
    }
}
