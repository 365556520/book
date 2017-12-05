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

Route::get('/','MemBerController@login');
Route::group(['namespace'=>'view'],function () {
    //login登录路由 ，register是注册路由、
    Route::get('login','MemBerController@login');
    Route::get('register','MemBerController@register')->name('register');
});
    //验证码路由用
Route::any('validateCode','Service\ValidateController@create')->name('validateCode');
//短信路由
Route::any('Code','Service\ValidateController@sendSMS')->name('phoneCode');
//注册路由
Route::post('Service/register','Service\MemberController@register')->name('sregister');
