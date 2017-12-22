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
        //从session中获取member值
        $member = $request->session()->get('member','');
        if ($member != ''){//登录成功
            $cart_items = $this->syncCart($member->member_id,$bk_cart_arr);
            return response()->view('cart',['cart_items'=>$cart_items])->withCookie('bk_cart',null);
        }
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
    //购物车的同步
    private function syncCart($member_id,$bk_cart_arr){
        //根据用户ID查找购物车表
       $cart_items = CartItem::where('member_id',$member_id)->get();

        $cart_items_arr = array();
        foreach ($bk_cart_arr as $value) {
            $index = strpos($value, ':');
            $product_id = substr($value, 0, $index);//产品id
            $count = (int) substr($value, $index+1);//产品数量

            // 判断离线购物车中product_id 是否存在 数据库中
            $exist = false;
            foreach ($cart_items as $temp) {
                if($temp->product_id == $product_id) { //看购物车里面是否存在此商品
                    if($temp->count < $count) { //查看存在商品的数量是否小于新添加的数量小于就更新
                        $temp->count = $count;
                        $temp->save();
                    }
                    $exist = true;
                    break;
                }
            }

            // 不存在则存储进来
            if($exist == false) {
                $cart_item = new CartItem;
                $cart_item->member_id = $member_id;
                $cart_item->product_id = $product_id;
                $cart_item->count = $count;
                $cart_item->save();
                $cart_item->product = Product::find($cart_item->product_id);
                array_push($cart_items_arr, $cart_item);
            }
        }

        // 为每个对象附加产品对象便于显示
        foreach ($cart_items as $cart_item) {
            $cart_item->product = Product::find($cart_item->product_id);
            array_push($cart_items_arr, $cart_item);
        }

        return $cart_items_arr;
    }


}