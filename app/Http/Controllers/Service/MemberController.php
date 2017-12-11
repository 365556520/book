<?php

namespace App\Http\Controllers\Service;

use App\Http\Model\Member;
use App\Http\Model\Temp_Email;
use App\Http\Model\Temp_Phone;
use App\Models\M3Email;
use App\Models\M3Result;
use App\Http\Controllers\Controller;
use App\Tool\UUID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

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
            $temp_phone = Temp_Phone::where('phone_phone',$phone)->first();
            if($temp_phone->phone_code == $phone_code){
                if(time() > strtotime($temp_phone->phone_deadline)){
                    $m3_result->status = 7;
                    $m3_result->message = '手机验证码超时失效';
                    return $m3_result->toJson();
                }

                $member = new Member;
                $member->member_phone = $phone;
                $member->member_password = Crypt::encrypt('bk'.$password);
                $member->save();
                $m3_result->status = 0;
                $m3_result->message = '注册成功';
                return $m3_result->toJson();
            }else{
                $m3_result->status = 8;
                $m3_result->message = '手机验证码不正确';
                return $m3_result->toJson();
            }
        }else{
            //邮箱注册
            if($validate_code == '' || strlen($validate_code) != 4) {
                $m3_result->status = 6;
                $m3_result->message = '验证码为4位';
                return $m3_result->toJson();
            }
            //验证码认证
            $validate_code_session = $request->session()->get('validate_code','');
            if ($validate_code_session != $validate_code){
                $m3_result->status = 10;
                $m3_result->message = '验证码不正确';
                return $m3_result->toJson();
            }
            $member = new Member;
            $member->member_email = $email;
            $member->member_password = Crypt::encrypt('bk'.$password);
            $member->save();
            $uuid = UUID::create();
            $m3_email = new M3Email;
            $m3_email->to = $email;
            $m3_email->cc='522392184@qq.com';
            $m3_email->subject = '杏子书店';
            $m3_email->content ="请于24小时点击该链接完成验证".route('emailjihuo')
                                .'?member_id='.$member->member_id
                                .'&code='.$uuid;
            $tempemail = new Temp_Email;
            $tempemail->email_member_id = $member->member_id;
            $tempemail->email_code = $uuid;
            $tempemail->email_deadline = date('y-m-d H:i:s',time()+24*60*60);
            $tempemail->save();
            Mail::send('emails', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
                $m->to($m3_email->to,'尊敬的用户')//收件人的邮箱和称呼
                    ->cc($m3_email->cc)
                    ->subject($m3_email->subject);
            });
            $m3_result->status = 0;
            $m3_result->message = '注册成功';
            return $m3_result->toJson();
        }

    }
    public function login(Request $request){
        $username = $request->get('username','');
        $password = $request->get('password','');
        $validate_code = $request->get('validate_code','');
        $m3_result = new M3Result;
        //判断验证码
        $validate_code_session = $request->session()->get('validate_code');
        if($validate_code != $validate_code_session){
            $m3_result->status = 1;
            $m3_result->message = '验证码不正确';
            return $m3_result->toJson();
        }
        $member = null;
        //判断账号是否含有@符号
        if(strpos($username,'@') == true){ //邮箱
            $member = Member::where('member_email',$username)->first();
        }else{//手机
            $member = Member::where('member_phone',$username)->first();
        }
        if($member == null){
            $m3_result->status = 2;
            $m3_result->message = '该用户不存在';
            return $m3_result->toJson();
        }else{//验证密码
            if('bk'.$password != Crypt::decrypt($member->member_password)){
                $m3_result->status = 3;
                $m3_result->message = '密码不正确';
                return $m3_result->toJson();
            }
        }
        //把登录成功的用户保存到session
        $request->session()->put('member',$member);
        $m3_result->status = 0;
        $m3_result->message = '登录成功';
        return $m3_result->toJson();
     }
}


