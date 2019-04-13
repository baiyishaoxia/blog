<?php

namespace App\Http\Controllers\Common;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    public function SendSms($type,$user_id)
    {
        $sms=new \App\Common\Api\Sms\Sms();
        $sms->send_type = 'YunPian';
        $user_info = User::info($user_id);
        $sms->code = $user_info['area'];     //区号
        $sms->mobile = $user_info['account'];//手机号码
        $rand = rand(100000,999999);
        //选择发送类型
        switch ($type){
            case 1:   //发送短信验证码
                $sms->content = $rand."(验证码）3分钟内有效。验证码提供给他人可能导致账号丢失";
                break;
            default:
                $sms->content = "你好！";
                break;
        }
        $response=$sms->send();
        if($response=="ok"){
            return json_encode(['status'=>'200', 'data'=>'发送成功']);
        }else{
            return json_encode(['status'=>'0','data'=>'发送失败']);
        }
    }
}
