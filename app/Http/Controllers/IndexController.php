<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    //admin.category(get)  列表
    public function index()
    {
      echo 'index';
    }

    //admin.category.create(get) 添加
    public function create()
    {

    }

    //admin.category(post) 处理添加
    public function store()
    {

    }

    //admin.category.show(get) 单个显示
    public function show()
    {

    }
    //admin.category.{category}(delete) 删除单个显示
    public function destroy()
    {

    }

    //admin.category.{category}.edit (get) 修改
    public function edit()
    {

    }

    //admin.category.{category}(put)  处理修改
    public function update()
    {

    }
    //测试自带的验证码
    public function getVerify()
    {
        return view('Test.verifycode');
    }
    //生成验证码
    public function getCreateverify($tmp)
    {
       //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder();
       //可以设置图片宽高及字体
        // 设置背景颜色
        $builder->setBackgroundColor(123, 203, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        $builder->setMaxOffset('4');

        $builder->build($width = 200, $height = 80, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        // var_dump($phrase);
        //把内容存入session
        \Session::flash('milkcaptcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
    //验证码验证
    public function getCode(Request $request)
    {
        $userInput = $request->get('captcha');
        if (strtolower(\Session::get('milkcaptcha')) == strtolower($userInput)) {
           //用户输入验证码正确
           return '您输入验证码正确';
        } else {
          //用户输入验证码错误
          return '您输入验证码错误';
        }
    }

}
