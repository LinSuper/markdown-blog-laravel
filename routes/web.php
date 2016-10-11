<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('article/edit', 'ArticleController@home');
//Route::post('article/edit', 'ArticleController@add');
Route::group(['prefix'=>'api'], function (){
    Route::resource('article', 'ArticleController');
    Route::resource('profile', 'ProfileController');
    Route::group(['middleware'=>'auth'], function (){
        Route::post('follow', 'RelationController@follow');
        Route::post('unfollow', 'RelationController@unfollow');
        Route::get('followerList', 'RelationController@followerList');
        Route::get('followeeList', 'RelationController@followeeList');
    });
});

//需要登录的路由定义
Route::group(['middleware' => 'auth'], function () {
    Route::put('article/{id}/edit', 'ArticleController@update');
    Route::get('article/{id}/edit', 'ArticleController@home');
});
