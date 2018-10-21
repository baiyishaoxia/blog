<?php

namespace App\Common\Api\Email;

use App\Common\Api\Email\Smtp\Smtp;
use App\Http\Model\Background\EmailKey;
use Mail;

class Email
{
    public $id;
    public $toemail;
    public $titel;
    public $content;
    public function send(){
        $email=\App\Http\Model\Background\Email::find($this->id);
        switch ($email->key){
            case 'smtp':
                $smtp=new Smtp();
                $smtp->is_ssl=EmailKey::read('smtp.is_ssl.'.$this->id);
                $smtp->from_address=EmailKey::read('smtp.username.'.$this->id);
                $smtp->host=EmailKey::read('smtp.host.'.$this->id);
                $smtp->from_name=EmailKey::read('smtp.from.'.$this->id);
                $smtp->password=EmailKey::read('smtp.password.'.$this->id);
                $smtp->port=EmailKey::read('smtp.port.'.$this->id);
                $smtp->username=EmailKey::read('smtp.username.'.$this->id);
                $smtp->content=$this->content;
                $smtp->titel=$this->titel;
                $smtp->toemail=$this->toemail;
                $smtp->email_id=$this->id;
                $smtp->send();
                break;
            default:
                return "该邮箱没有封装";
                break;
        }
    }
    /** --------- 参数说明 demo -------
     * smtp.host.1      =>  smtp.126.com
     * smtp.is_ssl.1    => ssl
     * smtp.port.1      => 465
     * smtp.from.1      => 白衣少侠
     * smtp.username.1  => tzf2273465837@126.com
     * smtp.password.1  => Authorization code
     * smtp.nick.1      => by 白衣少侠
     * */
}
