<?php

namespace App\Models;

class M3Result {
//$status状态
  public $status;
  //$message返回的消息
  public $message;

  public function toJson()
  {
      //把本类的$message和$status这2个参数转换成json格式返回
    return json_encode($this, JSON_UNESCAPED_UNICODE);
  }

}
