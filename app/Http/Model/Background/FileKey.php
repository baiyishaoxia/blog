<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Cache;

class FileKey extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     * @author tang
     */
    protected $table = 'file_key';
    /**
     * 不能被批量赋值的属性,如果你想要让所有属性都是可批量赋值的，可以将 $guarded 属性设置为空数组
     *
     * @var array
     * @author tang
     */
    protected $guarded = [];

    /**
     * 读取KEY
     * @param $name
     * @return mixed
     * @author tang
     */
    public static function read($name){
        $minutes=Carbon::now()->addMinute(10);
        $value = Cache::remember('file:'.$name,$minutes, function() use($name){
            return self::where('name',$name)->value('key');
        });
        return $value;
    }
}
