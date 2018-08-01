<?php

namespace App\Http\Model\Admin\MobileApi;

class M3Result {

  //状态
  public $status;
  //提示信息
  public $message;

    //region   将对象转为JSON返回        tang
    public function toJson()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
    //endregion


}
