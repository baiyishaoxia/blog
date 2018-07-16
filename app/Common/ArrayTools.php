<?php

namespace App\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArrayTools extends Controller
{
    /**
     * 向二维数组里面增加一个新的元素
     * @param $array        二维数组
     * @param $index        索引
     * @param $element      元素
     * @return mixed
     * @author tang
     */
    public static function arrayAddElement($array,$index,$element){
        foreach ($array as $k=>$v){
            $array[$k][$index]=$element;
        }
        return $array;
    }

    /**
     * 对象转数组
     * @param $array
     * @return array
     * @author tang
     */
    public static function objectToarray($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = self::objectToarray($value);
            }
        }
        return $array;
    }
}
