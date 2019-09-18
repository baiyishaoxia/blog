<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'sms_log';
    /**
     * 不能被批量赋值的属性,如果你想要让所有属性都是可批量赋值的，可以将 $guarded 属性设置为空数组
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 获取短信服务商
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sms(){
        return $this->belongsTo('App\Http\Model\Sms', 'sms_id');
    }

    /**
     * 创建日志
     * @param $sms_id
     * @param $prefixe
     * @param $mobile
     * @param $content
     * @return mixed
     */
    public static function add($sms_id,$prefixe,$mobile,$content){
        return self::create([
            'sms_id'    =>$sms_id,
            'prefixe'   =>$prefixe,
            'mobile'    =>$mobile,
            'content'   =>$content,
        ]);
    }
}
