<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\EncryptController;
use App\Http\Model\User;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    //admin.index(get)  列表
    public function index()
    {
      $mm = new  EncryptController();
      $jiami = $mm->encrypt_c('6666666');
      $jiemi = $mm->decrypt_c($jiami);
      var_dump($jiemi);
      dd(\DB::connection()->getPdo());
      echo 'index';
    }

    //admin.index.create(get) 添加
    public function create()
    {

    }

    //admin.index(post) 处理添加
    public function store()
    {

    }

    //admin.index.show(get) 单个显示
    public function show()
    {

    }
    //admin.index.{index}(delete) 删除单个显示
    public function destroy()
    {

    }

    //admin.index.{index}.edit (get) 修改
    public function edit()
    {

    }

    //admin.index.{index}(put)  处理修改
    public function update()
    {

    }
    //测试自带的验证码
    public function getVerify()
    {
        return view('Test.verifycode');
    }
    //生成验证码
    public function getCreateverify($tmp,$is_numb=true)
    {
       //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder();
        if($is_numb){
            $builder->setPhrase(rand(100,999));
        }
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

    //region 语言切换 session值   tang
    public function changeSession(Request $request)
    {
        //cn or en
        $lang = $request->get('lang');
        //写入session
        \Session::put('language',$lang);
        return redirect(\URL::action('Admin\IndexController@index'));
    }
    //endregion

}
