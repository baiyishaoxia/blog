<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'file';
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    //protected $fillable = [];
    /**
     * 不能被批量赋值的属性,如果你想要让所有属性都是可批量赋值的，可以将 $guarded 属性设置为空数组
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 文件上传的类型
     * @return array
     * @author tangzhifu
     */
    public static function type(){
        return[
            'file'       =>'文件',
            'image'      =>'图片',
            'video'      =>'视频'
        ];
    }

    /**
     * 获取正在启用的一个文件服务商
     * @param $type
     * @return mixed
     * @author tangzhifu
     */
    public static function enableOne($type){
        return File::where('is_enable',true)->where('type',$type)->first();
    }
}
