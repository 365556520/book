<?php

namespace App\Http\Controllers\Service;

use App\Http\Model\Member;
use App\Http\Model\Temp_Email;
use App\Http\Model\Temp_Phone;
use App\Models\M3Result;
use App\Tool\SMS\SendTemplateSMS;
use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidateController extends Controller
{
    //输入验证码
  public function create(Request $request)
  {
      $validateCode = new ValidateCode;
      //把当前生成的验证码存到session里面
      $request->session()->put('validate_code',$validateCode->getCode());
      return $validateCode->doimg();
  }
  //短信验证码
  public function sendSMS(Request $request){
      $m3Result = new M3Result();
      //Temp_Phone数据库对象
      $temp_phone = new Temp_Phone();
      //获取输入的手机号
     $phone = $request->input('phone','');
      if ($temp_phone->where('phone_phone',$phone)->first()){
          //如果手机号为空
          $m3Result->status = 9;
          $m3Result->message = '手机号已经注册过';
          return $m3Result->toJson();
      };
     if ($phone == ''){
        //如果手机号为空
         $m3Result->status = 1;
         $m3Result->message = '手机号不能为空';
         return $m3Result->toJson();
     }
      //创建短信验证码对象
      // $sendTemplateSMS = new SendTemplateSMS;
      //生成随机数$charset是数据源表示0-9的数字
      $code = '';
      $charset = '1234567890';
      $_len = strlen($charset) - 1;
      for ($i = 0;$i < 6;++$i) {
          $code .= $charset[mt_rand(0, $_len)];
      }
       $temp_phone->phone_phone = $phone;
       $temp_phone->phone_code = $code;
       $temp_phone->phone_deadline = date('y-m-d H:i:s',time()+3600);
       $temp_phone->save();
      //短信验证
      //$sendTemplateSMS->sendTemplateSMS("$phone", array($code,60), 1);
      $m3Result->status = 0;
      $m3Result->message = '发送成功';
      return $m3Result->toJson();
  }
  //邮箱验证
  public function validateEmail(Request $request){
    $member_id = $request->input('member_id','');
    $code = $request->input('code','');
    $tempemail = Temp_Email::where('email_member_id',$member_id)->first();
    if ($tempemail == null) {
        return '验证异常';
    };
    if($tempemail->email_code == $code) {
        if(time() > strtotime($tempemail->email_deadline)){
            return '该连接已超时失效';
        }
        $member =  Member::find($member_id);
        $member->member_active = 1;
        $member->save();
        return redirect()->route('login');
    }else{
        return '该连接已失效';
    }
  }
}
