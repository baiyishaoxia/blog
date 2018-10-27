<?php

namespace App\Http\Controllers\Background;

use App\Common\ArrayTools;
use App\Http\Model\Background\Config;
use App\Http\Model\Background\IpBlacklists;
use App\Http\Model\Background\IpWhitelists;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IpBlacklistsController extends Controller
{
    //region   列表        tang
    public function getList(Request $request){
        $data = IpBlacklists::orderby('id', 'desc');
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
        return view('background.ip_blacklist.list',compact('data'));
    }
    //endregion

    //region   添加        tang
    public function getCreate(){
        return view('background.ip_blacklist.add');
    }
    public function postCreate(Request $request){
        $data = $request->all();
        if(IpBlacklists::create($data)){
            return redirect(\URL::action('Background\IpBlacklistsController@getList'))->withErrors('添加成功');
        }else{
            return back()->withInput()->withErrors('添加失败');
        }
    }
    //endregion

    //region   编辑        tang
    public function getEdit($id){
        $data = IpBlacklists::find($id);
        return view('background.ip_blacklist.edit', compact('data'));
    }
    public function postEdit(Request $request){
        $data = IpBlacklists::find($request->get('id'));
        $data->start_ip = $request->get('start_ip');
        $data->end_ip = $request->get('end_ip');
        $data->type = $request->get('type');
        if($data->save()){
            return redirect(\URL::action('Background\IpBlacklistsController@getList'))->withErrors('修改成功');
        }else{
            return back()->withInput()->withErrors('修改失败');
        }
    }
    //endregion

    //region   删除        tang
    public function postDel(Request $request){
        $ret = IpBlacklists::whereIn('id', $request->get('id'))->delete();
        if($ret){
            return redirect(\URL::action('Background\IpBlacklistsController@getList'))->withErrors('删除成功');
        }else{
            return back()->withInput()->withErrors('删除失败');
        }
    }
    //endregion

    //region IP访问权限   
    public static function getIpAuth(Request $request)
    {
        $client_ip = $request->getClientIp();
        if ($client_ip == '::1'){
            $client_ip = '127.0.0.1';
        }
        $client_type = Config::read('sys_ip_admin_limit');
        switch ($client_type) {
            case 'black':
                $response = IpBlacklists::InfoByClientIp($client_ip, 'background');
                if ($response == true) {
                    abort(404);
                }
                break;
            case 'white':
                $response = IpWhitelists::InfoByClientIp($client_ip, 'background');
                if ($response == false) {
                    abort(404);
                }
                break;
        }
    }
    //endregion
}
