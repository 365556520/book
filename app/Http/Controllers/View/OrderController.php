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
        //��Ԫ����
        $product_ids_arr = ($product_ids!=''?explode(',',$product_ids) : array());
        //���ҳ���¼�û�
        $member = $request->session()->get('member','');
        $cart_items = CartItem::where('member_id',$member->member_id)->whereIn('product_id',$product_ids_arr)->get();
        $cart_items_arr = array();
        $total_price = 0;
        foreach ($cart_items as $cart_item){
            $cart_item->product = Product::find($cart_item->product_id);
            if($cart_item->product != null){
                //����۸�
                $total_price += $cart_item->product->product_price * $cart_item->count;
                //��������׷�Ӳ�ѯ����Ϣ
                array_push($cart_items_arr,$cart_item);
            }
        }
        return  view('order_commit',compact('cart_items_arr','total_price'));
    }
    public function toOrderList(Request $request ){
        return view('order_list');
    }
}