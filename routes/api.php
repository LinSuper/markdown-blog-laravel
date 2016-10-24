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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//Route::group(['prefix'=>'api'], function (){
    Route::post('fileUpload', 'FileController@update');
    Route::post('article/{id}/comment', 'CommentController@store');
    Route::get('article/{id}/comments', 'CommentController@index');
    Route::put('article/test', 'ArticleController@test');
    Route::resource('article', 'ArticleController');
    Route::resource('profile', 'ProfileController');
    Route::post('like', 'LikeController@like');
    Route::post('unlike', 'LikeController@unlike');
    //Route::group(['middleware'=>'auth'], function (){
        Route::post('follow', 'RelationController@follow');
        Route::post('unfollow', 'RelationController@unfollow');
        Route::get('followerList', 'RelationController@followerList');
        Route::get('followeeList', 'RelationController@followeeList');
    //});
//});
