<?php

namespace App\Http\Controllers\View;


use App\Http\Controllers\Controller;
use App\Http\Model\CartItem;
use App\Http\Model\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function toOrderCommit(Request $request,$product_ids)
    {
        //三元运算存在就转换成数组
        $product_ids_arr = ($product_ids!=''?explode(',',$product_ids) : array());
        //得到用户的信息
        $member = $request->session()->get('member','');
        $cart_items = CartItem::where('member_id',$member->member_id)->whereIn('product_id',$product_ids_arr)->get();
        $cart_items_arr = array();
        $total_price = 0;
        foreach ($cart_items as $cart_item){
            $cart_item->product = Product::find($cart_item->product_id);
            if($cart_item->product != null){
                //计算总加个
                $total_price += $cart_item->product->product_price * $cart_item->count;
                //把商品的信息插入到数组中
                array_push($cart_items_arr,$cart_item);
            }
        }
        return  view('order_commit',compact('cart_items_arr','total_price'));
    }
    public function toOrderList(Request $request ){
        return view('order_list');
    }
}