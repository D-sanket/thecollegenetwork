<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@home');

Route::group(['prefix' => 'auth'], function (){
    Route::get('login', 'PagesController@login')->middleware('rauth');
    Route::get('register', 'PagesController@register')->middleware('rauth');
    Route::post('login', 'FormController@login')->middleware('rauth');
    Route::post('register', 'FormController@register')->middleware('rauth');
    Route::get('logout', 'PagesController@logout');
});

Route::group(['middleware' => 'CustomAuth'], function (){
    Route::get('timeline', 'PagesController@timeline');
    Route::get('friends', 'PagesController@friends');
    Route::get('profile/{reg_no?}', 'PagesController@profile')->where('reg_no', '^([0-9]{4,4}[a-zA-Z]{3,3}[0-9]{3,3})$');
    Route::post('profile/upload/cover', 'ProfileController@cover');
    Route::post('profile/upload/cover/up', 'ProfileController@upcover');

    Route::group(['prefix' => 'friends'], function (){
        Route::post('add/{id}', 'FriendshipController@add')->where('id', '^([0-9]+)$');
        Route::post('unfriend/{id}', 'FriendshipController@unfriend')->where('id', '^([0-9]+)$');
        Route::post('cancel/{id}', 'FriendshipController@cancel')->where('id', '^([0-9]+)$');
        Route::post('accept/{id}', 'FriendshipController@accept')->where('id', '^([0-9]+)$');
        Route::post('reject/{id}', 'FriendshipController@reject')->where('id', '^([0-9]+)$');
        Route::post('block/{id}', 'FriendshipController@block')->where('id', '^([0-9]+)$');
        Route::post('unblock/{id}', 'FriendshipController@unblock')->where('id', '^([0-9]+)$');
        Route::post('search', 'FriendshipController@search');
    });

    Route::post('timeline/post/submit', 'PostController@submit');
    Route::post('timeline/post/fetch', 'PostController@fetch');
    Route::post('timeline/post/fetch/time', 'PostController@fetchTime');
    Route::post('timeline/post/fetch/comments', 'PostController@fetchComments');
    Route::post('timeline/post/comment', 'PostController@comment');

});