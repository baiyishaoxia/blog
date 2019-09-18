<?php

namespace App\Http\Controllers\Background;

use App\Common\ArrayTools;
use App\Http\Model\Background\SmsKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsKeyController extends Controller
{
    /**
     * GET 设置短信KEY
     * @param $sms_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSetKey($sms_id){
        $data=SmsKey::where('sms_id',$sms_id)->get();
        return view('background.sms.set_key',compact('data','sms_id'));
    }

    /**
     * POST 保存KEY
     * @param Request $request
     * @return $this
     */
    public function postSetKey(Request $request){
        if(!$request->has('data')){
            return back()->withErrors("最少有一个参数");
        }
        SmsKey::where('sms_id',$request->get('sms_id'))->delete();
        $data=$request->get('data');
        $data=array_values($data);
        $data=ArrayTools::arrayAddElement($data,'sms_id',$request->get('sms_id'));
        if(SmsKey::insert($data)){
            return redirect(\URL::action('Background\SmsController@getList'))->withErrors("配置成功");
        }else{
            return back()->withErrors("配置失败");
        }
    }
}
