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
    return  redirect()->route('login');
});
Route::group(['namespace'=>'View'],function () {
    //login登录路由 ，register是注册路由、
    Route::get('login','MemBerController@login')->name('login');
    Route::get('register','MemBerController@register')->name('register');
});
Route::group(['namespace'=>'Service'],function (){
    //验证码路由
    Route::any('validateCode','ValidateController@create')->name('validateCode');
    //短信路由
    Route::any('code','ValidateController@sendSMS')->name('phoneCode');
    //注册路由
    Route::post('service/register','MemberController@register')->name('rs');
    //激活邮箱注册
    Route::any('service/validate_email','ValidateController@validateEmail')->name('emailjihuo');
    //登录
    Route::post('service/login','MemberController@login')->name('slogin');
});
