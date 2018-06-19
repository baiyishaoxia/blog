<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    //后台主页
    public function index(){
        //数据库测试连接
        // $pdo =DB::connection()->getPdo();
        //  dd($pdo);
        return view('admin/index');
    }
    //子显示
    public function info()
    {
       return view('admin/info');
    }
    //修改密码
    public function pass(){
        if($input = Input::all()){
            //验证规则
            $rules = [
                //验证规则：必填、6-20位、匹配条件
               'password' => 'required|between:6,20|confirmed',
            ];
            //提示信息
            $message = [
                'password.required' => '新密码不能为空！',
                'password.between'  => '新密码必须在6-20位之间！',
                'password.confirmed'  => '两次密码不一致！',
            ];
            $validator = \Validator::make($input,$rules,$message);
            if($validator->passes()){
                $user = User::first();                          //获取信息
                $_password = \Crypt::decrypt($user->user_pass);//解密
                if($input['password_o'] == $_password){
                  $user->user_pass = \Crypt::encrypt($input['password']);//加密
                  $user->update();
                    //return redirect('admin/info'); //跳转
                    //return back()->with('errorss',);
                    return back()->withErrors('密码修改成功！');
                }else{
                    return back()->withErrors('原密码错误！');
                }
            }else{
                //dd($validator->errors()->all());
                //错误信息当参数传到了页面中
                return back()->withErrors($validator);
            }
        }else{
            return view('admin/pass');
        }
    }

}
