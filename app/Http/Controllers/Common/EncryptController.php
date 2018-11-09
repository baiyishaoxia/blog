<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EncryptController extends Controller
{
    private $iv = "1478523698563214";
    private $key = "1478523698563214";

    //加密
    public function encrypt($data){
        $cryptText = openssl_encrypt($data,"aes-256-cbc",  md5($this->key), null, $this->iv);
        $res = base64_encode($cryptText);
        return $res;
    }

    // 解密
    public function decrypt($res){
        $cryptText = base64_decode($res);
        $decode = openssl_decrypt($cryptText, "aes-256-cbc", md5($this->key), OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $this->iv);
        $decrypted=rtrim($decode,"\0");
        return $decrypted;
    }
    //openssl实现加密
    function encrypt_c($str){
        $str=serialize($str);
        $data=openssl_encrypt($str, 'AES-256-CBC',$this->key,0,$this->iv);
        $encrypt=base64_encode(json_encode($data));
        return $encrypt;
    }
    //openssl实现解密
    function decrypt_c($encrypt)
    {
        $encrypt = json_decode(base64_decode($encrypt), true);
        $decrypt = openssl_decrypt($encrypt, 'AES-256-CBC', $this->key, 0, $this->iv);
        $id = unserialize($decrypt);
        if($id){
            return $id;
        }else{
            return 0;
        }
    }
}
