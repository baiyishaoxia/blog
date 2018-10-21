<?php

namespace App\Common\Api\Email\Smtp;

use App\Http\Model\Background\EmailLog;
use Illuminate\Database\Eloquent\Model;
use Mail;
use Config;

class Smtp extends Model
{
    public $host;
    public $port;
    public $from_address;
    public $from_name;
    public $is_ssl=true;
    public $username;
    public $password;
    public $toemail;
    public $titel;
    public $content;
    public $email_id;
    public function send(){
        $mail['driver']='smtp';
        $mail['host']=$this->host;
        $mail['port']=$this->port;
        $mail['from']['address']=$this->from_address;
        $mail['from']['name']=$this->from_name;
        $mail['encryption']=$this->is_ssl;
        $mail['username']=$this->username;
        $mail['password']=$this->password;
        Config::set('mail.from.address',$this->from_address);
        Config::set('mail.from.name',$this->from_name);
        Config::set('mail.port',$this->port);
        Config::set('mail.username',$this->username);
        Config::set('mail.password',$this->password);
        Config::set('mail.host',$this->host);
        $toemail    =$this->toemail;
        $title      =$this->titel;
        $email_id   =$this->email_id;
        $content    =$this->content;
        Mail::raw($content, function ($message) use ($toemail,$title,$email_id,$content) {
            $message ->to($toemail)->subject($title);
            EmailLog::create([
                'email_id'      =>$email_id,
                'send_email'    =>$toemail,
                'send_title'    =>$title,
                'send_content'  =>$content
            ]);
        });
    }
}
