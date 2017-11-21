<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //在Model里面设置数据库表名字和主键
    protected $table='member';
    protected $primaryKey='member_id';
    //设为假的话，表示create方法执行时，不会对created_at和updated_at修改
//    public $timestamps=false;
    //排除不能填冲的字段
    protected $guarded=[];
}
