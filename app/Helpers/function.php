<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 21:57
 */


//region   使用文件方式的语言包        tang
function lang($data){
    if (!\Session::get('language')){
        \Session::put('language','cn');
    }
    if(\Session::get('language') == 'cn'){
        $data= \Config::get('language.'.$data);
    }
    return $data;
}
//endregion