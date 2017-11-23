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

Route::get('/', function () {
    return view('login');
});
Route::group(['namespace'=>'view'],function () {
    Route::get('login','MemBerController@login');
    Route::get('register','MemBerController@register');
});


Route::any('validateCode','Service\ValidateController@create');

