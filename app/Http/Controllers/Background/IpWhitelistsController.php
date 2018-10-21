<?php

namespace App\Http\Controllers\Background;

use App\Common\ArrayTools;
use App\Http\Model\Background\Config;
use App\Http\Model\Background\IpWhitelists;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IpWhitelistsController extends Controller
{
    //region   白名单列表        tang
    public function getList(Request $request){
        $data = IpWhitelists::orderby('id', 'desc');
        if($request->has('keywords')){
            if(ArrayTools::isIp($request->get('keywords'))==false){
                return back()->withErrors("Ip格式不正确");
            }
            $data = $data->where($request->get('field'), $request->get('keywords'));
        }
        if($request->has('type') && $request->get('type')!=''){
            $data = $data->where('type', $request->get('type'));
        }
        $data = $data->paginate(Config::read('sys.paginate'));
        return view('background.ip_whitelist.list', compact('data'));
    }
    //endregion

    //region   创建        tang
    public function getCreate(){
        return view('background.ip_whitelist.create');
    }
    public function postCreate(Request $request){
        $data = $request->all();
        if(IpWhitelists::create($data)){
            return redirect(\URL::action('Background\IpWhitelistsController@getList'))->withErrors('添加成功');
        }else{
            return back()->withInput()->withErrors('添加失败');
        }
    }
    //endregion

    //region   编辑        tang
    public function getEdit($id){
        $data = IpWhitelists::find($id);
        return view('background.ip_whitelist.edit', compact('data'));
    }
    public function postEdit(Request $request){
        $data = IpWhitelists::find($request->get('id'));
        $data->start_ip = $request->get('start_ip');
        $data->end_ip = $request->get('end_ip');
        $data->type = $request->get('type');
        if($data->save()){
            return redirect(\URL::action('Background\IpWhitelistsController@getList'))->withErrors('修改成功');
        }else{
            return back()->withInput()->withErrors('修改失败');
        }
    }
    //endregion

    //region   删除        tang
    public function postDel(Request $request){
        $ret = IpWhitelists::whereIn('id', $request->get('id'))->delete();
        if($ret){
            return redirect(\URL::action('Background\IpWhitelistsController@getList'))->withErrors('修改成功');
        }else{
            return back()->withInput()->withErrors('修改失败');
        }
    }
    //endregion
}
