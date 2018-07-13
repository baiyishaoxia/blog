<?php

namespace App\Http\Model\Common;

use Gregwar\Captcha\CaptchaBuilder;

class Captcha
{
    //region 验证码   Panjunwei
    public static function build($width=100,$height=30,$is_numb=true){
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder();
        if($is_numb){
            $builder->setPhrase(rand(1000,9999));
        }
        //可以设置图片宽高及字体
        $builder->build($width, $height, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        \Session::flash('captcha_data', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
    //endregion
    public static function code($width=100,$height=30){
        $url='/captcha/'.$width.'/'.$height;
        return "<img src='{$url}' class='captcha' style='cursor: pointer' width='{$width}' height='{$height}'/>";
    }
}
