<?php

namespace App\Http\Controllers\Service;


use App\Http\Controllers\Controller;

use App\Http\Model\CartItem;
use App\Models\M3Result;
use Illuminate\Http\Request;

class CartController extends Controller
{   //添加商品
    public function addCart(Request $request,$product_id)
    {
        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '添加成功';
        // 如果当前已经登录
        $member = $request->session()->get('member', '');
        if($member != '') {
            $cart_items = CartItem::where('member_id', $member->member_id)->get();
            $exist = false;
            foreach ($cart_items as $cart_item) {
                if($cart_item->product_id == $product_id) {
                    $cart_item->count ++;
                    $cart_item->save();
                    $exist = true;
                    break;
                }
            }
            if($exist == false) {
                $cart_item = new CartItem;
                $cart_item->product_id = $product_id;
                $cart_item->count = 1;
                $cart_item->member_id = $member->member_id;
                $cart_item->save();
            }

            return $m3_result->toJson();
        }
        //从cookie查找键值对
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
    //购物删除商品
    public function  deleteCart(Request $request){

        $m3Result = new M3Result;
        $m3Result->status = 0;
        $m3Result->message = '删除成功';
        //获取传送过来要删除的id集合
        $product_ids = $request->input('product_ids','');
        if ($product_ids == ''){
            $m3Result->status = 1;
            $m3Result->message = '数据id为空';
            $m3Result->toJson();
        }
        //explode把这个字符串以，的格式转换成数组
        $product_ids_arr = explode(',',$product_ids);
        $member = $request->session()->get('member', '');
        if($member != '') {
            // 已登录
            CartItem::whereIn('product_id', $product_ids_arr)->delete();
            return $m3Result->toJson();
        }

        $product_ids = $request->input('product_ids', '');
        if($product_ids == '') {
            $m3Result->status = 1;
            $m3Result->message = '书籍ID为空';
            return $m3Result->toJson();
        }

        // 未登录
        //从cookie中获取里面的数值
        $bk_cart = $request->cookie('bk_cart');
        //如果不为空就把这从cookie中获取的字符串以,形式转成数组
        $bk_cart_arr = ($bk_cart != null ? explode(',',$bk_cart):array());
        foreach ($bk_cart_arr as $key => $value){
            //strpos查找:在$value中出现的位置
            $index = strpos($value,':');
            //substr抽取从0到:位置的值(这个商品id)
            $product_id = substr($value,0,$index);
            //如果这个商品的id存在则删除（in_array查找$product_id在$product_ids_arr这个数组中是否存在）
            if (in_array($product_id,$product_ids_arr)){
                //array_splice 去掉$bk_cart_arr数组中键为$key的数据删除1个
                array_splice($bk_cart_arr,$key,1);
                continue;
            };
        }

        //删除成功从新把Cookie数据修改implode把数组转换成字符串以,为分隔符
        return response($m3Result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }
}