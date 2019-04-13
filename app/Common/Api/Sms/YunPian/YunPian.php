<?php

namespace App\Common\Api\Sms\YunPian;


use anlutro\cURL\cURL;
use App\Http\Model\SmsKey;

class YunPian
{

    /**
     * 发送短信
     * @param $code
     * @param $mobile
     * @param $content
     * @param $sign
     */
    public static function send($code,$mobile,$text,$sign){
        if($code!='+86'){
            //$mobile=urlencode($code.$mobile);
            $mobile = htmlentities($code.$mobile);
        }
        $url='http://sms.yunpian.com/v2/sms/single_send.json';
        $apikey=SmsKey::read('yunpian.apikey');
        $text='【'.$sign.'】'.$text;
        $data=[
            'text'=>$text,
            'apikey'=>$apikey,
            'mobile'=>$mobile
        ];
        $curl=new cURL();
        $response=$curl->post($url,$data);
        $response=$response->body;
        $response=json_decode($response,true);
        if($response['code']==0){
            return "ok";
        }else{
            return $response['msg'].$response['detail'];
        }
    }

    public static function check_send($code,$mobile,$text,$sign){
        if($code!='+86'){
            $mobile=urlencode($code.$mobile);
        }
        $url='http://sms.yunpian.com/v2/sms/single_send.json';
        $apikey=SmsKey::read('yunpian.apikey');
        $text='【'.$sign.'】'.$text;
        $data=[
            'text'=>$text,
            'apikey'=>$apikey,
            'mobile'=>$mobile
        ];
        $curl=new cURL();
        $response=$curl->post($url,$data);
        $response=$response->body;
        $response=json_decode($response,true);
        if($response['code']==0){
            return "ok";
        }else{
            return $response['msg'].$response['detail'];
        }
    }

    /**
     * 获取短信数量
     */
    public function getSurplusNum(){

    }
}
