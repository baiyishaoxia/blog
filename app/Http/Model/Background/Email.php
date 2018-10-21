<?php

namespace App\Http\Model\Background;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'email';
    protected $guarded = [];
    public $timestamps = true;

    //region   邮箱服务器        tang
    public static function getSmtpList(){
        $minutes=Carbon::now()->addMinute(10);
        $value = \Cache::remember('emal:sign:',$minutes, function(){
            return self::pluck('name','id')->toArray();
        });
        return $value;
    }
    //endregion


    //region   返回邮件名称 键值对        tang
    public static function getEmail(){
        return self::pluck('name', 'id');
    }
    //endregion
}
