<?php

namespace App\Http\Controllers\Service;

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
      return $validateCode->doimg();
  }
  //短信验证码
  public function sendSMS(Request $request){
      $m3Result = new M3Result();
      //获取输入的手机号
     $phone = $request->input('phone','');
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
       $temp_phone = new Temp_Phone();
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
}
