<?php

namespace App\Http\Controllers\View;


use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function toOrderPay(Request $request)
    {
        return  view('order_pay',compact('categorys'));
    }

}