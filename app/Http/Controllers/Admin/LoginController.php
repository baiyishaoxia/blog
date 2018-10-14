<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

//引入验证码类文件(自定义验证码)
//require_once 'org/code/Code.class.php';

class LoginController extends CommonController
{
    //登陆
    public function login(){
        if($input = Input::all()){
//            $code = new \Code();
//            $_code = $code->get();
//            if(strtoupper($input['code']) != $_code){
//                return back()->with('msg','验证码错误!');
//            }
            //使用laravel内置验证码
            if (strtolower(\Session::get('milkcaptcha')) != strtolower($input['code'])) {
                return back()->with('msg','验证码错误!');
            }
            //取一条记录
            $admin = Admin::where("username",$input['user_name'])->first();
            if($admin->username != $input['user_name'] || $admin->password != $input['user_pass']){
                return back()->with('msg','用户名或密码错误!');
            }
            if($admin->is_lock==true){
                return back()->withInput()->withErrors("账户已被锁定");
            }
            $admin->login_count=$admin->login_count+1;
            $admin->save();
            //将登陆信息写入session
            session(['admin'=>$admin]);
            \Session::put('admin_id',$admin->id);
            return redirect('admin/index');
        }else{
            //删除session
            session(['admin'=>null]);
            \Session::put('admin_id',null);
            //服务器信息
            //dd($_SERVER);
            return view('admin/login');
        }
    }
    //创建验证码
    public function code()
    {
        $code = new \Code();
        $code->make();
    }
    //退出
    public function quit()
    {
        session(['admin'=>null]);
        return redirect('admin/login');
    }
    
    
    
    
    
    
    
    //获取验证码值
    public function getcode(){
        $code= new\Code();
        echo $code->get();
    }
    //加密解密算法
    public function crypt(){
        $str = '123456';
        $str_p = 'eyJpdiI6ImxpaGlGc0NjbklhVEVPVHB0ekFqVVE9PSIsInZhbHVlIjoiSlhpbjNnYkFDemIzRjh6bEtoUnpkdz09IiwibWFjIjoiNzI3YTBhZDBlZjU4MjJlY2NhY2E5NjA5NGJiZGQxY2E0YWIxN2ZmYzIxM2M4MzQxYWE3NTAwMTVjOWI4OWRkMCJ9';
        echo \Crypt::encrypt($str),"<br/>";
        echo \crypt::decrypt($str_p);
    }

}
