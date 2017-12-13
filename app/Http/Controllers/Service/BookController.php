<?php

namespace App\Http\Controllers\Service;


use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use App\Models\M3Result;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getCategoryByParentId($parent_id)
    {
        $categorys = Category::where('parent_id',$parent_id)->get();
        $m3Result = new M3Result;
        $m3Result->status = 0;
        $m3Result->message = '返回成功';
        $m3Result->categorys = $categorys;
        return $m3Result->toJson();
    }

}