<?php

namespace App\Http\Controllers\Background;

use App\Http\Model\Background\Email;
use App\Http\Model\Background\EmailLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailLogController extends Controller
{
    //region   邮件日志列表        tang
    public function getList(Request $request){
        $data = EmailLog::orderby('id', 'desc');
        if($request->has('keywords') && $request->get('keywords')!=''){
            if('email_id' == $request->get('field')){
                $data = $data->where('email_id', Email::where('name', $request->get('keywords'))->first()->id);
            }else{
                $data = $data->where($request->get('field'), $request->get('keywords'));
            }
        }
        $data = $data->paginate(10);
        $email = Email::getEmail();
        return view('background.email.show', compact('data', 'email'));
    }
    //endregion
}
