<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/UserSignup" , "Apis\UserController@UserSignUp");
Route::get("/UserSignup" , "Apis\GeneralController@echoempty");

Route::get("/UserLogin" , "Apis\GeneralController@echoempty");
Route::post("/UserLogin" , "Apis\UserController@UserLogin");

Route::get("/UserForgetPassword" , "Apis\GeneralController@echoempty");
Route::post("/UserForgetPassword" , "Apis\UserController@ForgetPassword");

Route::get("/MainScreen"  , "Apis\GeneralController@echoempty");
Route::post("/MainScreen"  , "Apis\HomeController@get_main_screen_data");

Route::get("/GetCategories"  , "Apis\GeneralController@echoempty");
Route::post("/GetCategories"  , "Apis\HomeController@get_category_pages");

Route::get("/GetCategoryPostsList"  , "Apis\GeneralController@echoempty");
Route::post("/GetCategoryPostsList"  , "Apis\PostController@get_category_posts_list");

Route::get("/GetStafferList"  , "Apis\GeneralController@echoempty");
Route::post("/GetStafferList"  , "Apis\PostController@get_list_of_writers");


Route::get("/GetPostDetails"  , "Apis\GeneralController@echoempty");
Route::post("/GetPostDetails"  , "Apis\PostController@get_post_details");

Route::get("/GetPostComments"  , "Apis\GeneralController@echoempty");
Route::post("/GetPostComments"  , "Apis\PostController@get_post_comments");

Route::get("/AddComment"  , "Apis\GeneralController@echoempty");
Route::post("/AddComment"  , "Apis\PostController@insert_comment");

Route::get("/writerPage"  , "Apis\GeneralController@echoempty");
Route::post("/writerPage"  , "Apis\UserController@get_writer_data");

Route::get("/ContactUs"  , "Apis\GeneralController@echoempty");
Route::post("/ContactUs"  , "Apis\UserController@cotact_us");

Route::get("/UserSearch"  , "Apis\GeneralController@echoempty");
Route::post("/UserSearch"  , "Apis\HomeController@user_search");



