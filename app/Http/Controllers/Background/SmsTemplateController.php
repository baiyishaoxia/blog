<?php

namespace App\Http\Controllers\Background;

use App\Http\Model\Background\Config;
use App\Http\Model\Background\SmsTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsTemplateController extends Controller
{
    /**
     * GET请求获取短信模板列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(Request $request){
        $data = SmsTemplate::orderby('id', 'desc');
        if($request->has('keywords')){
           $data = $data->where($request->get('field'), $request->get('keywords'));
        }
        $data = $data->paginate(Config::read('sys.paginate'));
        return view('background.sms_template.list', compact('data'));
    }

    /**
     * GET请求进入创建页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate(){
        return view('background.sms_template.create');
    }

    /**
     * POST请求获取POST数据进行短信模板的创建
     * @param Request $request
     * @return $this
     */
    public function postCreate(Request $request){
        $data = $request->all();
        if(SmsTemplate::create($data)){
            return redirect(\URL::action('Background\SmsTemplateController@getList'))->withErrors('添加成功');
        }else{
            return back()->withInput()->withErrors('添加失败');
        }
    }

    /**
     * GET请求获取数据进入编辑页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($id){
        $data = SmsTemplate::find($id);
        return view('background.sms_template.edit', compact('data'));
    }

    /**
     * POST请求获取POST数据进行短信模板的修改
     * @param Request $request
     * @return $this
     */
    public function postEdit(Request $request){
        $data = SmsTemplate::find($request->get('id'));
        $data->title = $request->get('title');
        $data->call = $request->get('call');
        $data->text = $request->get('text');
        $data->is_sys = $request->has('is_sys')?true:false;
        if($data->save()){
            return redirect(\URL::action('Background\SmsTemplateController@getList'))->withErrors('修改成功');
        }else{
            return back()->withInput()->withErrors('修改失败');
        }
    }

    /**
     * POST请求获取POST数据进行短息模板的删除
     * @param Request $request
     * @return $this
     */
    public function postDel(Request $request){
        $ret = SmsTemplate::whereIn('id', $request->get('id'))->delete();
        if($ret){
            return redirect(\URL::action('Background\SmsTemplateController@getList'))->withErrors('删除成功');
        }else{
            return back()->withInput()->withErrors('删除失败');
        }
    }
}
