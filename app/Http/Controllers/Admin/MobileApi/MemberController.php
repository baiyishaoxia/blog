<?php

namespace App\Http\Controllers\Admin\MobileApi;

use App\Common\UUID;
use App\Http\Model\Admin\MobileApi\M3Email;
use App\Http\Model\Admin\MobileApi\M3Result;
use App\Http\Model\Admin\MobileApi\MobileEmail;
use App\Http\Model\Admin\MobileApi\MobileMember;
use App\Http\Model\Admin\MobileApi\MobilePhone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    //region   登录        tang
    public function login(Request $request)
    {
        $return_url =  $request->get('return_url','');
        if(\Request::ajax()){
           $m3_result = new M3Result();
           //接收数据
           $input = $request->only('account','password','validate_code');
           $valicode_session = $request->session()->get('validate_code');
           if(strtolower($input['validate_code']) != $valicode_session ){
               $m3_result->status = 1;
               $m3_result->message = '验证码不正确！';
               return $m3_result->toJson();
           }
           if(strpos($input['account'],'@') == true){
               $member = MobileMember::where('email',$input['account'])->first();
           }else{
               $member = MobileMember::where('phone',$input['account'])->first();
           }
           if($member == null){
               $m3_result->status = 2;
               $m3_result->message = '该用户不存在！';
               return $m3_result->toJson();
           }else{
               if(\Crypt::decrypt($member->password) != $input['password']){
                   $m3_result->status = 3;
                   $m3_result->message = '用户密码不正确！';
                   return $m3_result->toJson();
               }
           }

        \Session::put('member',$member);
        //$request->session()->put('member',$member);
        $m3_result->status = 0;
        $m3_result->message = '登录成功！';
        return $m3_result->toJson();
        }
        if(session('member')){
            return redirect('admin/mobile/category');
        }
        return view('admin.mobile_api.login',compact('return_url'));
    }
    //endregion

    //region   显示注册        tang
    public function register($value='')
    {
        return view('admin.mobile_api.register');
    }
    //endregion

    //region   处理注册        tang
    public function postRegister(Request $request)
    {
        //接收数据
        $email = $request->input('email', '');
        $phone = $request->input('phone', '');
        $password = $request->input('password', '');
        $confirm = $request->input('confirm', '');
        $phone_code = $request->input('phone_code', '');
        $validate_code = $request->input('validate_code', '');
        //实例化错误信息类
        $m3_result = new M3Result();
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

        // 手机号注册
        if($phone != '') {
            if($phone_code == '' || strlen($phone_code) != 6) {
                $m3_result->status = 5;
                $m3_result->message = '手机验证码为6位';
                return $m3_result->toJson();
            }
            //点击发送验证码会生成一条记录，在这里先校验验证码再判断该记录的验证码过期时间
            $tempPhone = MobilePhone::where('phone', $phone)->first();
            if(!$tempPhone){
                $m3_result->status = 201;
                $m3_result->message = '请确认手机号码是否正确！';
                return $m3_result->toJson();
            }
            if($tempPhone->code == $phone_code) {
                if(time() > strtotime($tempPhone->deadline)) {
                    $m3_result->status = 7;
                    $m3_result->message = '手机验证码已过期';
                    return $m3_result->toJson();
                }
                $member = MobileMember::where('phone', $phone)->first();
                //如果该手机号不存在，就创建一条记录，否则修改该记录
                if($member == null) {
                    $member = new MobileMember();
                }
                $member->phone = $phone;
                $member->password = \Crypt::encrypt($password);
                $member->save();
                //注册成功
                $m3_result->status = 0;
                $m3_result->message = '注册成功';
                return $m3_result->toJson();
            } else {
                $m3_result->status = 7;
                $m3_result->message = '手机验证码不正确';
                return $m3_result->toJson();
            }

        // 邮箱注册
        } else {
            if($validate_code == '' || strlen($validate_code) != 4) {
                $m3_result->status = 6;
                $m3_result->message = '验证码为4位';
                return $m3_result->toJson();
            }
            $validate_code_session = $request->session()->get('validate_code', '');
            if($validate_code_session != strtolower($validate_code)) {
                $m3_result->status = 8;
                $m3_result->message = '验证码不正确';
                return $m3_result->toJson();
            }

            //如果该邮箱不存在，就创建一条记录，否则修改该记录
            $member = MobileMember::where('email', $email)->first();
            if($member == null) {
                $member = new MobileMember();
            }
            $member->email = $email;
            $member->password = \Crypt::encrypt($password);
            $member->save();
            //此时的状态是未激活

            $uuid = UUID::create();

            $m3_email = new M3Email();
            $m3_email->to = $email;
            $m3_email->cc = '1174881637@qq.com';
            $m3_email->subject = '邮箱验证';
            $m3_email->content = '请于24小时点击该链接完成验证. ';
            $m3_email->url = \URL::action('Admin\MobileApi\ValidateController@validateEmail').'?member_id='.$member->id.'&code='.$uuid;

            //如果该邮箱的用户不存在，就创建一条记录，否则修改该记录
            $tempEmail = MobileEmail::where('member_id', $member->id)->first();
            if($tempEmail == null){
                $tempEmail = new MobileEmail();
            }
            $tempEmail->member_id = $member->id;
            $tempEmail->code = $uuid;
            $tempEmail->deadline = date('Y-m-d H-i-s', time() + 24*60*60);
            $tempEmail->save();
            //保存了email对应的用户id以及过期时间

            \Mail::send('admin.mobile_api.email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
                //在email配置中指定了from值此处可不用写了
                // $m->from('hello@app.com', 'Your Application');
                $m->to($m3_email->to, '尊敬的用户')
                  ->cc($m3_email->cc)
                  ->subject($m3_email->subject);
            });

            $m3_result->status = 0;
            $m3_result->message = '注册成功，请登录邮箱及时激活账号！';
            return $m3_result->toJson();
        }
    }
    //endregion

    //region   登出        tang
    public function logout()
    {
        session(['member'=>null]);
        return redirect(\URL::action('Admin\MobileApi\MemberController@login'));
    }
    //endregion



}
