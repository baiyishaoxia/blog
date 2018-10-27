<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';
    protected $guarded = [];
    public $timestamps = true;

    //region   读取配置文件        tang
    public static function read($name=''){
        $cache_time = \Carbon\Carbon::now()->addMinutes(10);
        if($name==''){
            $config=\Cache::remember("config:all",$cache_time,function (){
                $all=self::pluck('value','name');
                return $all;
            });
        }else{
            $name=str_replace('.','_',$name);
            $config=\Cache::remember("config:".$name,$cache_time,function () use ($name){
                $all=self::where('name',$name)->pluck('value','name');
                return $all;
            });
            if(isset($config[$name])) {
                $config = $config[$name];
            }else{
                \Log::info($name."该配置不存在");
                return false;
            }
        }
        return $config;
    }
    //endregion

    //region   写入配置文件        tang
    public static function add($config){
        if(isset($config['_token'])){
            unset($config['_token']);
        }
        $where_key=[];
        $add_data=[];
        $k=0;
        foreach ($config as $key => $val){
            //保存有效值
            if($val != null){
                $where_key[$k]=$key;
                $add_data[$k]['name']=$key;
                $add_data[$k]['value']=$val;
                $k++;
            }
        }
        $r2 = true;
        //是否修改或新增
        foreach ($add_data as $key => $val){
             $res = self::where('name',$val['name'])->first();
             if($res){
                 $r2 = self::where('name',$val['name'])->update(['value'=>$val['value']]);
             }else{
                 $r2 = self::create(['name'=>$val['name'],'value'=>$val['value']]);
             }
        }
        //self::destroy($where_key);
        //$r2=self::insert($add_data);
        if($r2){
            return true;
        }else{
            return false;
        }
    }
    //endregion
}
