<?php

namespace App\Http\Model\Common;


use App\Http\Model\Background\Config;

class Image
{
    /**
     * 剪切图片，并生成图片的缩略图
     * @param $path
     * @param $width
     * @param $height
     * @return string
     */
    public static function fit($path, $width,$height){
        $oldpath=$path;
        //新的图片路径
        $newpath=explode('/',$path);
        $newpath=$newpath[count($newpath)-1];
        $newpath=explode('.',$newpath);
        $file_extension=$newpath[1];
        $file_name=$newpath[0];
        //是否开启缩略图
        if (Config::read('sys.is_open_thumb')=="1"){
            $newpath=$file_name.'_'.$width.'_'.$height;
        }
        //是否开启水印
        if (Config::read('sys.is_open_water')=="1"){
            $newpath=$newpath.'_water';
        }
        $newpath=$newpath.'.'.$file_extension;
        $newpath='storage/tmp/'.$newpath;
        #如果不存在tmp文件夹，自动创建
        if(!file_exists(public_path('storage/tmp'))){
            mkdir(public_path('storage/tmp'));
        }
        #如果不存在缩略图文件
        if(!file_exists(public_path($newpath))) {
            $img = \Image::make('storage/'.$oldpath);
            //是否开启缩略图
            if (Config::read('sys.is_open_thumb')=="1") {
                $img->fit($width, $height);
            }
            //是否开启水印
            if (Config::read('sys.is_open_water')=="1"){
                // 插入水印, 水印位置在原图片的右下角, 距离下边距 10 像素, 距离右边距 15 像素
                $img->insert(str_replace('/storage','storage',\Storage::url(Config::read('sys.water'))), 'bottom-right', Config::read('sys.water_bottom'), Config::read('sys.water_left'));
            }
            $img->save(public_path($newpath));
        }
        return '/'.$newpath;
    }
}
