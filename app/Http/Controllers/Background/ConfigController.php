<?php

namespace App\Http\Controllers\Background;

use App\Http\Model\Background\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    //region   系统设置        tang
    public function getConfig(){
        $data=Config::read();
        return view('background.config.config',compact('data'));
    }
    public function postConfig(Request $request){
        if(\Cache::has('again_form')){
            return back()->withInput()->withErrors("请1分钟后再提交");
        }
        $data=$request->all();
        $data['sys_is_open']=$request->has('sys_is_open')?true:false;
        if(Config::add($data)){
            //用于验证是否重复提交 [设置refuse_form值, 缓存1分钟]
            \Cache::put('again_form','again_form',1);
            return back()->withInput()->withErrors("修改成功");
        }else{
            return back()->withInput()->withErrors("修改失败");
        }
    }
    //endregion

    //region   进入访问限制选项        tang
    public function getIpLimit(){
        $data=Config::read();
        return view('background.config.ip_limit',compact('data'));
    }
    public function postIpLimit(Request $request){
        $data=$request->all();
        if(Config::add($data)){
            return back()->withInput()->withErrors("修改成功");
        }else{
            return back()->withInput()->withErrors("修改失败");
        }
    }
    //endregion
}
