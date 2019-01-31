<?php

namespace App\Http\Model\Common;

use App\Http\Model\Background\File;
use App\Http\Model\Background\FileKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Upload
{
//

    /**
     * 针对上传的文件进行存储并放置不通的目录下面
     * @param $request_file
     * @param $type
     * @return array
     * @author tangzhifu
     */
    public static function file(UploadedFile $request_file, $type){
        #获取图片服务商
        $file           =File::enableOne($type);
        $file_size      =FileKey::read('size.'.$file->id);
        $file_type      =FileKey::read('type.'.$file->id);
        $file_savetype  =FileKey::read('savetype.'.$file->id);
        #判断大小是否超出
        $now_size=$request_file->getClientSize()/1024/1024;
        if($now_size>$file_size){
            return [
                'status'=>'0',
                'msg'=>'大小超出允许范围，现在大1小：'.$now_size.'M，要求大小：'.$file_size.'M',
            ];
        }
        #判断后缀格式是否正确
        if(!in_array($request_file->getClientOriginalExtension(),explode(',',$file_type))){
            return [
                'status'=>'0',
                'msg'=>'不允许该后缀',
            ];
        }
        #上传
        $files=new \App\Common\Api\File\File();
        $files->disk='local';
        $files->file_path=$type.'/'.date($file_savetype);
        $files->file_name=$request_file;
        $path=$files->store();
        return[
            'status'=>'1',
            'name'=>$request_file->getClientOriginalName(),
            'size'=>self::converKit($request_file->getClientSize()),
            'path'=>$path,
            'url'=>Storage::url($path),
            'msg'=>'上传成功'
        ];
    }

    /**
     * 返回大小，从byte的大小满1024自动进1位
     * @param $size
     * @param string $type
     * @return string
     * @author tangzhifu
     */
    private static function converKit($size, $type='byte'){
        if($size>1024){
            $size=$size/1024;
            switch ($type){
                case 'byte':
                    $type='KB';
                    break;
                case 'KB':
                    $type='M';
                    break;
                case 'M':
                    $type='G';
                    break;
                case 'G':
                    $type='T';
                    break;
            }
            return self::converKit($size,$type);
        }else{
            return $size.$type;
        }
    }

    //视频上传--------------------配置文件未指定 fileVal属性将默认 file
    public static function videoFile(UploadedFile $request_file, $type){
        #获取图片服务商
        $file           = File::enableOne($type);
        $file_size      = '104857600';//100M
        $file_type      = 'mp4,MP4,AVI,avi,RMVB,rmvb,3gp,3GP';
        $file_savetype  = FileKey::read('savetype.'.$file->id);
        #判断大小是否超出
        if($request_file->getClientSize()>$file_size){
            return [
                'status'=>'0',
//                'msg'=>'大小超出允许范围，现在大小：'.$request_file->getClientSize().'，要求大小：'.$file_size,
                'msg'=>'大小超出允许范围，要求大小：100M',
            ];
        }
        #判断后缀格式是否正确
        if(!in_array($request_file->getClientOriginalExtension(),explode(',',$file_type))){
            return [
                'status'=>'0',
                'msg'=>'不允许该后缀',
            ];
        }
        #上传
        $files=new \App\Common\Api\File\File();


        $files->disk='local';
        $files->file_path=$type.'/'.date($file_savetype);
        $files->file_name=$request_file;
        $path=$files->store();

        return[
            'status'=>'1',
            'name'=>$request_file->getClientOriginalName(),
            'size'=>self::converKit($request_file->getClientSize()),
            'path'=>$path,
            'url'=>Storage::url($path),
            'msg'=>'上传成功'
        ];
    }
}
