<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexNavController extends Controller
{
    //获取用户打字练习成绩
    public function getUserScore()
    {
        $arr = [
                ["name"=>"张三","score"=>10],
                ["name"=>"李四","score"=>20],
                ["name"=>"王五","score"=>50],
                ["name"=>"小六","score"=>100],
        ];
        //读取json文件
        $json_string = file_get_contents('./storage/tmp/typing_score.json');
        $data = json_decode($json_string, true);
        if(empty($data)){
            $data = $arr;
        }
        return json_encode($data);
    }
    //提交用户打字成绩
    public function postUserScore(Request $request)
    {
        $name = $request->get('name');
        $usetime = $request->get('score');
        //获取数据
        $data["name"] =  $name;
        $data["score"] = $usetime;
        //读取原json文件
        $json_string = file_get_contents('./storage/tmp/typing_score.json');
        $old_arr = json_decode($json_string,true);
        //是否为空
        if(!empty($json_string)){
            //去重
            for($i=0;$i<count($old_arr);$i++){
                if($old_arr[$i]["name"] == $data["name"]){
                    unset($old_arr[$i]);
                }
            }
            //追加数据
            array_push($old_arr,$data);
            //重置键名
            $old_arr = array_values($old_arr);
            $data = json_encode($old_arr,JSON_UNESCAPED_UNICODE);
        }else{
            $data = json_encode([$data]);
        }
        //写入json文件
        file_put_contents('./storage/tmp/typing_score.json',$data);
        return json_encode(["msg"=>$usetime]);
    }
}
