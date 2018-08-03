<?php

namespace App\Http\Controllers\Admin\MobileApi;

use App\Common\ValidateCode;
use App\Http\Controllers\Controller;

use App\Http\Model\Admin\MobileApi\MobileEmail;
use App\Http\Model\Admin\MobileApi\MobileMember;
use App\Http\Model\Admin\MobileApi\MobilePhone;
use Illuminate\Http\Request;
use App\Common\SMS\SendTemplateSMS;


class ValidateController extends Controller
{
    //region   生成验证码        tang
    public function create(Request $request)
    {
        $validateCode = new ValidateCode;
        $request->session()->put('validate_code', $validateCode->getCode());
        return $validateCode->doimg();
    }
    //endregion

    //region   发送验证码 （使用容联云通讯）       tang
    public function sendSMS(Request $request)
    {
        $m3_result = new \App\Http\Model\Admin\MobileApi\M3Result();

        $phone = $request->input('phone', '');
        if($phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号不能为空';
            return $m3_result->toJson();
        }
        if(strlen($phone) != 11 || $phone[0] != '1') {
            $m3_result->status = 2;
            $m3_result->message = '手机格式不正确';
            return $m3_result->toJson();
        }

        $sendTemplateSMS = new SendTemplateSMS;
        $code = '';
        $charset = '1234567890';
        $_len = strlen($charset) - 1;
        for ($i = 0;$i < 6;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        $m3_result = $sendTemplateSMS->sendTemplateSMS($phone, array($code, 10), 1);
        if($m3_result->status == 0) {
            $tempPhone = MobilePhone::where('phone', $phone)->first();
            //如果该手机号不存在，就创建一条记录，否则修改该记录
            if($tempPhone == null) {
                $tempPhone = new MobilePhone;
            }
            $tempPhone->phone = $phone;
            $tempPhone->code = $code;
            $tempPhone->deadline = date('Y-m-d H-i-s', time() + 60*60);
            $tempPhone->save();
        }
        return $m3_result->toJson();
    }
    //endregion

    //region   验证邮箱激活账号        tang
    public function validateEmail(Request $request)
    {
        $member_id = $request->input('member_id', '');
        $code = $request->input('code', '');
        if($member_id == '' || $code == '') {
            return '验证异常';
        }
        $tempEmail = MobileEmail::where('member_id', $member_id)->first();
        if($tempEmail == null) {
            return '此记录不存在，验证异常';
        }
        if($tempEmail->code == $code) {
            if(time() > strtotime($tempEmail->deadline)) {
                return '该链接已失效';
            }
            $member = MobileMember::find($member_id);
            $member->active = 1;
            $member->save();
            return redirect(\URL::action('Admin\MobileApi\MemberController@login'));
        } else {
            return '该链接已失效';
        }
    }
//endregion

}
