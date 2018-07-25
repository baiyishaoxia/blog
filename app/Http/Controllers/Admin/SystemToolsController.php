<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class SystemToolsController extends Controller
{
    public function getIndex()
    {
        return view('admin.system_tools.img_cat');
    }

    public function create(Request $request)
    {
        dd($request->all());
    }

    //region   图片裁剪        tang
    public function imgCat(Request $request)
    {
        $path = $request->get('path');
        $width = $request->get('width');
        $height = $request->get('height');
        $oldpath=$path;
        if(empty($path) || empty($width) || empty($height)){
            return [
                'status'=>1,
                'msg'  =>'裁剪失败!请上传文件后并指定宽高!',
                'img_url' => ''
            ];
        }
        //图片地址是否在源文件中
        if (file_exists(base_path('public/'.$path)) == false){
            return [
                'status'=>1,
                'msg'  =>'裁剪失败!源文件不存在,请重新上传!',
                'img_url' => $path
            ];
        }
        //图片地址为空
        if ($path == '/storage/'){
            return $path;
        }
        $path=str_replace("/storage",'storage',$oldpath);
        //根据/划分转数组
        $path=explode('/',$path);
        $path=$path[count($path)-1];
        //根据.划分转数组
        $path=explode('.',$path);
        //拼接新文件名
        $path=$path[0].'_'.$width.'_'.$height.'.'.$path[1];
        $fit_path='storage/tmp/'.$path;
        if(file_exists(base_path('public/storage/'.$fit_path))==false) {
            $img = Image::make(str_replace("/storage", 'storage', $oldpath));
            $img->resize($width, $height);
            // 插入水印, 水印位置在原图片的右下角, 距离下边距 0 像素, 距离右边距 0 像素
            $img->insert('storage/tmp/watermark/watermark.png', 'bottom-right', 0, 0);
            $img->save($fit_path);
            $data = [
                'status'=>0,
                'msg'  =>'裁剪成功!目录保存在/public'.'/'.$fit_path,
                'img_url' => 'tmp/'.$path
            ];
        }
        return $data;
    }
    //endregion

}
