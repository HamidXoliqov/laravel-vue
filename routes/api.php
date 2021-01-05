<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function(){
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('logout','AuthController@logout');
        Route::get('profile','AuthController@profile');
    });

});

Route::group(['middleware' => 'auth:api'], function(){
    Route::group(['middleware' =>'scope:user'], function() {

        Route::resource('categories','CategoryController');


        Route::get('get-categories','ProductController@categories');
        Route::resource('products','ProductController');


        Route::get('/user-scope', function() {
            return response()->json([
                'message'=>'User can access this !',
                'status_code'=>200
            ],200);
        });
    });
    Route::group(['middleware' =>'scope:admin'], function() {
        Route::get('/admin-scope', function() {
            return response()->json([
                'message'=>'Admin can access this !',
                'status_code'=>200
            ],200);
        });
    });

    // Route::group(['middleware' => 'auth:api'], function(){

    //     Route::post('edit-category', function(){
    //         return response()->json([
    //             'message'=>'Admin access',
    //             'status_code'=>200,
    //         ],200);
    //     })->middleware('scope:admin');

    //     Route::post('create-category', function(){
    //         return response()->json([
    //             'message'=>'Everyone access',
    //             'status_code'=>200,
    //         ],200);
    //     })->middleware('scope:admin,user');
    // });
});
