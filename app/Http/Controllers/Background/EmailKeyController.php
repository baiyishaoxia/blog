<?php

namespace App\Http\Controllers\Background;

use App\Common\ArrayTools;
use App\Http\Model\Background\EmailKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailKeyController extends Controller
{
    //region   设置key视图        tang
    public function getSetKey($email_id){
        $data=EmailKey::where('email_id',$email_id)->get();
        return view('background.email.set_key',compact('data','email_id'));
    }
    //endregion

    //region   保存        tang
    public function postSetKey(Request $request){
        try
        {
            if(!$request->has('data')){
                return back()->withErrors("最少有一个参数");
            }
            EmailKey::where('email_id',$request->get('email_id'))->delete();
            $data=$request->get('data');
            $data=array_values($data);
            $data=ArrayTools::arrayAddElement($data,'email_id',$request->get('email_id'));
            if(EmailKey::insert($data)){
                return redirect(\URL::action('Background\EmailController@getList'))->withErrors("配置成功");
            }else{
                return back()->withErrors("配置失败");
            }
        }catch (\Exception $e)
        {
            //AdminErrorLog::log($e);
            return back()->withErrors("操作异常");
        }
    }
    //endregion
}
