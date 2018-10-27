<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $table = 'admin_log';
    protected $guarded = [];

    //region   将请求的路由记录下来        tang
    public static function log(){
        $ip=\Request::getClientIp();
        $log=[
            'url'       =>\Request::path(),
            'type'      =>\Request::method(),
            'request'   =>json_encode(\Request::all()),
            'ip'        =>$ip,
            'area'        =>''
        ];
        if(\Session::get('admin_id')){
            $log['admin_id']     =\Session::get('admin_id');
        }else{
            $log['admin_id']     =null;
        }
        if(\Request::method() == "POST"){
            self::create($log);
        }
    }
    //endregion
}
