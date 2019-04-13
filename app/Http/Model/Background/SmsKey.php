<?php

namespace App\Http\Model\Background;

use Carbon\Carbon;
use Cache;
use Illuminate\Database\Eloquent\Model;

class SmsKey extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'sms_key';
    /**
     * 不能被批量赋值的属性,如果你想要让所有属性都是可批量赋值的，可以将 $guarded 属性设置为空数组
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 读取KEY
     * @param $name
     * @return mixed
     */
    public static function read($name){
        $minutes=Carbon::now()->addMinute(10);
        $value = Cache::remember('sms:'.$name,$minutes, function() use($name){
            return self::where('name',$name)->value('key');
        });
        return $value;
    }
}
