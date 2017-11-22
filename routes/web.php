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
use App\Http\Model\Member;
use App\Http\Model\Pdt_Images;
use App\Http\Model\Pdt_Content;
use App\Http\Model\Product;
use App\Http\Model\Category;
Route::get('/', function () {
    echo "测试";
    echo "ceshi";
    return Category::all();
});
