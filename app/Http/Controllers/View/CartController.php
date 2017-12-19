<?php

namespace App\Http\Controllers\View;


use App\Http\Controllers\Controller;
use App\Http\Model\CartItem;
use App\Http\Model\Product;
use App\Models\M3Result;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function toCart(Request $request)
    {   $cart_items = array();
        //从cookie查找键值对
        $bk_cart = $request->cookie('bk_cart');
        //$bk_cart如果不为空就用explode（拆分字符串函数）根据，为间隔拆分$bk_carr如果是空就给个空字符串
        $bk_cart_arr = ($bk_cart != null ? explode(',',$bk_cart):array());
        foreach ($bk_cart_arr as $key => $value){
            //strpos查找:在$value中出现的位置
            $index = strpos($value,':');
            $cart_item = new CartItem;
            //购物车信息的id
            $cart_item->id = $key;
            //购物车中的商品的id
            $cart_item->product_id = substr($value,0,$index);
            //购物车中商品的数量
            $cart_item->count = (int)substr($value,$index+1);
            //查找这个商品
            $cart_item->product = Product::find($cart_item->product_id) ;

            if($cart_item->product != null){
                array_push($cart_items,$cart_item);
            }
        }
        return view('cart')->with('cart_items',$cart_items);
    }

}