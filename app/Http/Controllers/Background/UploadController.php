<?php

namespace App\Http\Controllers\Background;

use App\Http\Model\Common\Upload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    /**
     * 上传文件
     * @param Request $request
     * @return array
     * @author tang
     */
    public function postFile(Request $request){
        $request_file=$request->file('Filedata');
        return Upload::file($request_file,'file');
    }

    /**
     * 上传图片
     * @param Request $request
     * @return array
     * @author tang
     */
    public function postImg(Request $request){
        $request_file=$request->file('Filedata');
        return Upload::file($request_file,'image');
    }

    /**
     * 上传视频
     * @param Request $request
     * @return array
     * @author tang
     */
    public function postVideo(Request $request){
        return Upload::file($request_file=$request->file('Filedata'),'video');
    }
    public function postVideoFile(Request $request){
        return Upload::videoFile($request_file=$request->file('file'),'file');
    }
    /**
     * 编辑器上传图片
     * @param Request $request
     * @return mixed
     * @author tang
     */
    public function postEditorImg(Request $request){
        $info= Upload::file($request_file=$request->file('wangEditorH5File'),'image');
        return $info['url'];
    }
}
