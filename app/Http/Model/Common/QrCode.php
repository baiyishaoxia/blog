<?php

namespace App\Http\Model\Common;


use App\Http\Model\Background\Config;

class QrCode
{
    protected $qrcode;
    public function __construct()
    {
        if(!file_exists(public_path('storage/qrcodes'))){
            mkdir(public_path('storage/qrcodes'));
        }
        $qrcode_size            =Config::read('sys.qrcode_size');
        $qrcode_margin          =Config::read('sys.qrcode_margin');
        $is_open_qrcode         =Config::read('sys.is_open_qrcode');
        $qrcode_water           =Config::read('sys.qrcode_water');
        $qrcode_percent         =Config::read('sys.qrcode_percent')/100;
        $color_red              =Config::read('sys.color_red');
        $color_green            =Config::read('sys.color_green');
        $color_blue_red         =Config::read('sys.color_blue_red');
        $background_color_red   =Config::read('sys.background_color_red');
        $background_color_green =Config::read('sys.background_color_green');
        $background_color_blue  =Config::read('sys.background_color_blue');
        $this->qrcode           =\QrCode::format('png');
        $this->qrcode           =$this->qrcode->encoding('UTF-8');
        $this->qrcode           =$this->qrcode->size($qrcode_size);
        $this->qrcode           =$this->qrcode->color($color_red,$color_green,$color_blue_red);
        $this->qrcode           =$this->qrcode->backgroundColor($background_color_red,$background_color_green,$background_color_blue);
        $this->qrcode           =$this->qrcode->margin($qrcode_margin);
        if($is_open_qrcode=='1'){
            $this->qrcode=$this->qrcode->merge("/public/storage/".$qrcode_water,$qrcode_percent);
        }
    }

    /**
     * 生成文字二维码
     * @param $string 二维码的内容
     * @param $name   二维码的名称
     * @return string 路径
     */
    public function generate($string,$name){
        $path='storage/qrcodes/'.$name.'.png';
        if(!file_exists(public_path($path))) {
            $this->qrcode->generate($string,public_path($path));
        }
        return '/'.$path;
    }
}
