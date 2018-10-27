<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class IpBlacklists extends Model
{
    protected $table = 'ip_blacklists';
    protected $guarded = [];
    public $timestamps = true;

    //region   应用列表        tang
    public static function typeList(){
        return[
            'background'=>'后台应用',
            'home'=>'前台应用'
        ];
    }
    //endregion

    //region   定义访问器,获取type对应的值        tang
    public function getTypeAttribute($key)
    {
        $type=self::typeList();
        return $type[$key];
    }
    //endregion

    //region   根据ip查询        tang
    public static function InfoByClientIp($clent_ip,$type)
    {
        $data = self::where('start_ip','<=',$clent_ip)->where('end_ip','>=',$clent_ip)->where('type',$type)->get();
        if(count($data)>0){
            return true;
        }else{
            return false;
        }
    }
    //endregion
}
