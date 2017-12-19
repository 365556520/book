<?php

namespace App\Http\Controllers\Service;


use App\Http\Controllers\Controller;

use App\Models\M3Result;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addCart(Request $request,$product_id)
    {   //从cookie查找键值对
        $bk_cart = $request->cookie('bk_cart');
        //$bk_cart如果不为空就用explode（拆分字符串函数根据），为间隔拆分$bk_carr如果是空就给个空字符串
        $bk_cart_arr = ($bk_cart != null ? explode(',',$bk_cart):array());
        $count = 1;
        foreach ($bk_cart_arr as &$value){ //&是引用 基本类型需要引用（相当于$value引用$bk_cart_arr的地址）
            //strpos查找:在$value中出现的位置
            $index = strpos($value,':');
            //substr截取这个字符串从0开始到:号位置的这个字符串
            if(substr($value,0,$index) ==$product_id){
                //substr($value,$index+1)截取:号后面的那一位数然后转换成int类型后在+1（也就是为该商品加1）
                $count = ((int)substr($value,$index+1)) + 1;
                $value = $product_id .':'.$count;
                break;
            }
        }
        if ($count == 1){
            array_push($bk_cart_arr,$product_id .':'.$count);
        }
        $m3Result = new M3Result;
        $m3Result->status = 0;
        $m3Result->message = '添加成功';
//        implode是把数组连接成字符串
        return response($m3Result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }
    //删除商品
    public function  deleteCart(Request $request){
        $m3Result = new M3Result;
        $product_ids = $request->input('product_ids','');
        if ($product_ids == ''){
            $m3Result->status = 1;
            $m3Result->message = '数据id为空';
            $m3Result->toJson();
        }
        $product_ids_arr = explode(',',$product_ids);
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart != null ? explode(',',$bk_cart):array());
        foreach ($bk_cart_arr as $key => $value){
            //strpos查找:在$value中出现的位置
            $index = strpos($value,':');
            $product_id = substr($value,0,$index);
            //如果存在则删除
            if(in_array($product_id,$bk_cart_arr)){
                array_splice($bk_cart_arr,$key,1);
                continue;
            }
        }
        $m3Result->status = 0;
        $m3Result->message = '删除成功';
        return response($m3Result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }
}