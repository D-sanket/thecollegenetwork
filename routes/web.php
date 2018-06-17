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

Route::group(['prefix' => 'auth',  'middleware' => 'rauth'], function() {
    Route::get('login', 'PagesController@login');
    Route::get('register', 'PagesController@register');
    Route::post('login', 'FormController@login');
    Route::post('register', 'FormController@register');
});