<?php

namespace App\Http\Controllers\View;


use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function toCategory(Request $request)
    {
        $categorys = Category::whereNull('parent_id')->get();
        return  view('category',compact('categorys'));
    }

}