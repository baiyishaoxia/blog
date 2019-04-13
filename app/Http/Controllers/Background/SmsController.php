<?php

namespace App\Http\Controllers\Background;

use App\Http\Model\Background\Config;
use App\Http\Model\Background\Sms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    /**
     * GET 列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(){
        $data=Sms::orderBy('id','desc');
        $data=$data->paginate(Config::read('sys.paginate'));
        return view('background.sms.list',compact('data'));
    }

    /**
     * GET 创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate(){
        return view('background.sms.create');
    }

    /**
     * POST 保存
     * @param Request $request
     * @return $this
     */
    public function postCreate(Request $request){
        $data=$request->all();
        //$data['key']=json_encode([]);
        $data['is_enable'] = isset($data['is_enable'])?true:false;
        if (Sms::create($data)){
            return redirect(\URL::action('Background\SmsController@getList'))->withErrors("添加成功");
        }else{
            return back()->withInput()->withErrors("添加失败");
        }
    }

    /**
     * GET请求获取数据进入编辑页面
     * @param $sms_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($sms_id){
        $data = Sms::find($sms_id);
        return view('background.sms.edit', compact('data'));
    }

    /**
     * POST请求获取POST数据进行短信服务商的修改
     * @param Request $request
     * @return $this
     */
    public function postEdit(Request $request){
        $data = Sms::where('id', $request->get('id'))->first();
        $data->name = $request->get('name');
        $data->sign = $request->get('sign');
        $data->key = $request->get('key');
        $data->is_enable = $request->has('is_enable')?true:false;
        if($data->save()){
            return redirect(\URL::action('Background\SmsController@getList'))->withErrors('修改成功');
        }else{
            return back()->withErrors('修改失败');
        }
    }
    /**
     * POST请求获取数据进行事务删除操作
     * @param Request $request
     * @return $this
     */
    public function postDel(Request $request){
        \DB::beginTransaction();
        $ret = Sms::whereIn('id', $request['id'])->delete();
        if(Sms::whereIn('id', $request['id'])->count()>0){
            $key_Ret = SmsKey::whereIn('sms_id', $request['id'])->delete();
        }else{
            $key_Ret = true;
        }
        if($key_Ret && $ret){
            \DB::commit();
            return redirect(\URL::action('Background\SmsController@getList'))->withErrors('删除成功');
        }else{
            \DB::rollBack();
            return back()->withErrors('删除失败');
        }
    }

    /**
     * GET 发送测试短信
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Ruiec.Simba
     */
    public function getTestSms(){
        $sms=Sms::pluck('name','key');
        return view('background.sms.test',compact('sms'));
    }

    /**
     * GET 接收发送测试短信的请求，并发送成功
     * @param Request $request
     * @return $this
     */
    public function postTestSms(Request $request){
        $sms=new \App\Common\Api\Sms\Sms();
        $sms->send_type=$request->get('type');
        $sms->code=$request->get('prefixe');
        $sms->mobile=$request->get('mobile');
        $sms->content=$request->get('text');
        $response=$sms->send();
        if($response=="success"){
            return back()->withErrors("发送成功");
        }else{
            return back()->withInput()->withErrors($response);
        }
    }

    /**
     * GET ，查询短信剩余数量
     * @param $sms_id
     * @return $this
     */
    public function getSurplusNum($sms_id){
        $name=Sms::where('id',$sms_id)->value('key');
        $sms=new \App\Common\Api\Sms\Sms();
        $sms->send_type=$name;
        return back()->withErrors($sms->getSurplusNum());
    }
}
