<?php

namespace App\Common\Api\Sms;


use App\Common\Api\Sms\YunPian\YunPian;
use App\Http\Model\SmsLog;

/**
 * Class Sms
 * @package App\Common\Api\Sms
 */
class Sms
{
    /**
     * 发送的URL
     * @var
     */
    protected $send_url;
    /**
     * 采用哪个短信服务商进行短信的发送
     * @var string
     */
    public $send_type='';
    /**
     * 发送的手机号
     * @var
     */
    public $mobile;
    /**
     * 手机号码前缀，例如+86
     * @var
     */
    public $code;
    /**
     * 短信内容
     * @var
     */
    public $content;
    /**
     * 短信签名
     * @var
     */
    public $sign;
    /**
     * 短信服务商ID
     * @var
     */
    private $sms_id;

    /**
     * 发送短信
     * @return string
     */
    public function send(){
        $sms_id='';
        switch ($this->send_type){
            case 'YunPian':
                $sms=\App\Http\Model\Sms::infoByKey($this->send_type);
                $this->sign=$sms->sign;
                $sms_id=$sms->id;
                $response=YunPian::send($this->code,$this->mobile,$this->content,$this->sign);
                break;
            case 'YunPianEng':
                $sms=\App\Http\Model\Sms::infoByKey($this->send_type);
                $this->sign=$sms->sign;
                $sms_id=$sms->id;
                $response=YunPian::send($this->code,$this->mobile,$this->content,$this->sign);
                break;
            default:
                $response='default';
                break;
        }
        if($response =='ok'){
            #添加短信日志
            SmsLog::add($sms_id,$this->code,$this->mobile,$this->content);
        }
        return $response;
    }


    /**
     * 获取短信数量
     * @return string
     */
    public function getSurplusNum(){
        switch ($this->send_type){
            case 'YunPian':
                $response='该平台不提供查询余额接口，请登录平台查询';
                break;
            default:
                $response='default';
                break;
        }
        return $response;
    }

}
