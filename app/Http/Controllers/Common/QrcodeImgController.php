<?php

namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrcodeImgController extends Controller
{
    //region   生成分享二维码          tang
    public static function getShareQrcode($urls,$user_id){
        //生成二维码
        $files_name = $user_id.'.png';
        $url ='storage/qrcodes/'.$files_name;
        if(!file_exists(public_path($url))){
            \QrCode::format('png')->size(300)->merge('/public/admin/style/images/qrcode.png',.20)->margin(0)->generate($urls,public_path($url));
        }
        return '/'.$url;
    }
    //endregion

    //region   生成分享二维码          tang
    public  function getAjaxQrcode(Request $request){
        $user_id = $request->user_id;
        $urls = $request->urls;
        //生成二维码
        $files_name = $user_id.'.png';
        $url ='storage/qrcodes/'.$files_name;
        if(!file_exists(public_path($url))){
            \QrCode::format('png')->size(300)->merge('/public/admin/style/images/qrcode.png',.20)->margin(0)->generate($urls,public_path($url));
        }
        return ['status'=>'200','msg'=>'创建成功,/'.$url,'url'=>'/'.$url];
    }
    //endregion
}
