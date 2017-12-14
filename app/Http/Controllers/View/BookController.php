<?php

namespace App\Http\Controllers\View;


use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use App\Http\Model\Product;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function toCategory(Request $request)
    {    //产品分类
        $categorys = Category::whereNull('parent_id')->get();
        return  view('category',compact('categorys'));
    }
    public function toProduct($category_id,$product_name)
    {  //产品列表
        $products = Product::where('category_id',$category_id)->get();
        return  view('product',compact('products','product_name'));
    }
}