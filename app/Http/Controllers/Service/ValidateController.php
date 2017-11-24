<?php

namespace App\Http\Controllers\Service;

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
  public function sendSMS($value = ''){
      //创建短信验证码对象
      $sendTemplateSMS = new SendTemplateSMS;
      //生成随机数$charset是数据源表示0-9的数字
      $code = '';
      $charset = '1234567890';
      $_len = strlen($charset) - 1;
      for ($i = 0;$i < 6;++$i) {
          $code .= $charset[mt_rand(0, $_len)];
      }
      //短信验证
     //$sendTemplateSMS->sendTemplateSMS("18937737625", array($code,60), 1);
  }
}
