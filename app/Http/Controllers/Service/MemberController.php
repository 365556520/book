<?php

namespace App\Http\Controllers\Service;

use App\Http\Model\Temp_Phone;
use App\Models\M3Result;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function register(Request $request){
        $email =$request->input('email','');
        $phone =$request->input('phone','');
        $password = $request->input('password','');
        $confirm = $request->input('confirm','');
        $phone_code = $request->input('phone_code','');
        $validate_code = $request->input('validate_code','');
        $m3_result = new M3Result;
        if($email == '' && $phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号或邮箱不能为空';
            return $m3_result->toJson();
        }
        if($password == '' || strlen($password) < 6) {
            $m3_result->status = 2;
            $m3_result->message = '密码不少于6位';
            return $m3_result->toJson();
        }
        if($confirm == '' || strlen($confirm) < 6) {
            $m3_result->status = 3;
            $m3_result->message = '确认密码不少于6位';
            return $m3_result->toJson();
        }
        if($password != $confirm) {
            $m3_result->status = 4;
            $m3_result->message = '两次密码不相同';
            return $m3_result->toJson();
        }
        //手机号注册
        if($phone != '') {
            if ($phone_code == '' || strlen($phone_code) != 6) {
                $m3_result->status = 5;
                $m3_result->message = '手机验证码为6位';
                return $m3_result->toJson();
            }
            //邮箱注册
        }else{
            if($validate_code == '' || strlen($validate_code) != 4) {
                $m3_result->status = 6;
                $m3_result->message = '验证码为4位';
                return $m3_result->toJson();
            }
        }
        return $m3_result->toJson();
    }
}


