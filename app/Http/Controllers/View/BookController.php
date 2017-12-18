<?php

namespace App\Http\Controllers\View;


use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use App\Http\Model\Pdt_Content;
use App\Http\Model\Pdt_Images;
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
    public  function  toPdtContent(Request $request,$product_id){
        //产品详情
        $product = Product::find($product_id);
        //产品介绍内容
        $pdt_content = Pdt_Content::where('product_id',$product_id)->first();
        //轮播图片
        $pdt_images = Pdt_Images::where('product_id',$product_id)->get();
        //从cookie查找键值对
        $bk_cart = $request->cookie('bk_cart');
        //$bk_cart如果不为空就用explode（拆分字符串函数根据），为间隔拆分$bk_carr如果是空就给个空字符串
        $bk_cart_arr = ($bk_cart != null ? explode(',',$bk_cart):array());
        $count = 0;
        foreach ($bk_cart_arr as $value){ //&是引用 基本类型需要引用（相当于$value引用$bk_cart_arr的地址）
            //strpos查找:在$value中出现的位置
            $index = strpos($value,':');
            //substr截取这个字符串从0开始到:号位置的这个字符串
            if(substr($value,0,$index) ==$product_id){
                //substr($value,$index+1)截取:号后面的那一位数然后转换成int类型后在+1（也就是为该商品加1）
                $count = ((int)substr($value,$index+1));
                break;
            }
        }
        return  view('pdt_content',compact('product','pdt_content','pdt_images','count'));
    }
}