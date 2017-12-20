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
//分配视图路由组
Route::group(['namespace'=>'View'],function () {
    //login登录路由 ，register是注册路由、
    Route::get('login','MemBerController@login')->name('login');
    Route::get('register','MemBerController@register')->name('register');
    //主页
    Route::get('category','BookController@toCategory')->name('category');
    //商品列表
    Route::get('category_id/{category_id}/{product_name}','BookController@toProduct');
    //产品详情
    Route::get('product_id/{product_id}','BookController@toPdtContent')->name('pdtcontent');
    //购物车页面
    Route::get('cart', 'CartController@toCart');
    Route::group(['middleware' => ['check.login']], function () {
        Route::get('order_pay', 'OrderController@toOrderPay');
    });
});
//处理路由组
Route::group(['prefix' => 'service','namespace'=>'Service'],function (){
    //验证码路由
    Route::get('validateCode','ValidateController@create')->name('validateCode');
    //短信路由
    Route::post('code','ValidateController@sendSMS')->name('phoneCode');
    //激活邮箱注册
    Route::get('validate_email','ValidateController@validateEmail')->name('emailjihuo');
    //注册路由
    Route::post('register','MemberController@register')->name('rs');
    //登录
    Route::post('login','MemberController@login')->name('slogin');
    //商品分类路由
    Route::get('getCategoryByParentId/{id}','BookController@getCategoryByParentId');
    //购物车添加路由
    Route::get('cart/add/{product_id}','CartController@addCart');
    //购物车删除商品
    Route::get('cart/delete','CartController@deleteCart')->name('cdelete');
});
