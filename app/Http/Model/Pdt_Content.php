<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Pdt_Content extends Model
{
    //在Model里面设置数据库表名字和主键
    protected $table='pdt_content';
    protected $primaryKey='content_id';
    //设为假的话，表示create方法执行时，不会对created_at和updated_at修改
//    public $timestamps=false;
    //排除不能填冲的字段
    protected $guarded=[];
}
