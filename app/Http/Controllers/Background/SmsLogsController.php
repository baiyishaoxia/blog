<?php

namespace App\Http\Controllers\Background;

use App\Http\Model\Background\Config;
use App\Http\Model\Background\SmsLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsLogsController extends Controller
{
    public function getList(Request $request){
        $data = SmsLog::orderby('id', 'desc');
        if($request->has('keywords')){
            $data = $data->where($request->get('field'), $request->get('keywords'));
        }
        $data = $data->paginate(Config::read('sys.paginate'));
        return view('background.sms_log.list', compact('data'));
    }
}
