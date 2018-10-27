<?php

namespace App\Http\Controllers\Background;

use App\Http\Model\Background\Email;
use App\Http\Model\Background\EmailKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    //region   列表        tang
    public function getList(Request $request){
        $data = Email::orderby('id', 'desc');
        if($request->has('keywords')){
            $data = $data->where($request->get('field'), $request->get('keywords'));
        }
        $data = $data->paginate(10);
        return view('background.email.list', compact('data'));
    }
    //endregion

    //region   新增        tang
    public function getCreate(){
        return view('background.email.create');
    }
    public function postCreate(Request $request){
        \DB::beginTransaction();
        $data = $request->all();
        $data['is_enable'] = isset($data['is_enable'])?true:false;
        $key_Ret = true;
        $ret = Email::create($data);
        if('smtp' == $data['key']) {
            $str = Email::where('key', 'smtp')->first()->id;
            $attr = ['host', 'is_ssl', 'port', 'from', 'username', 'password', 'nick'];
            for ($i = 0; $i < count($attr); $i++) {
                $arr[$i]['email_id'] = $str;
                $arr[$i]['name'] = 'smtp.' . $attr[$i] . '.1';
                $arr[$i]['key'] = '1';
            }
            $key_Ret = EmailKey::insert($arr);
        }
        if($key_Ret && $ret){
            \DB::commit();
            return redirect(\URL::action('Background\EmailController@getList'))->withErrors('添加成功');
        }else{
            \DB::rollBack();
            return back()->withInput()->withErrors('添加失败');
        }

    }
    //endregion

    //region   修改        tang
    public function getEdit($id){
        $data = Email::find($id);
        return view('background.email.edit', compact('data'));
    }
    public function postEdit(Request $request){
        //修改Emai数据表数据
        $input = Email::find($request->get('id'));
        $input->name = $request->get('name');
        $input->key = $request->get('key');
        $input->is_enable = $request->has('is_enable')?true:false;
        $res1=$input->save();
        //修改EmailKEY数据
        $res2=true;
        //1、如果以前是key==smtp,现在不是，并且key里面为空，增加数据
        if($request->get('key')=='smtp' && empty(EmailKey::first())){
            $str = Email::where('key', 'smtp')->first()->id;
            $attr = ['host', 'is_ssl', 'port', 'from', 'username', 'password', 'nick'];
            for ($i = 0; $i < count($attr); $i++) {
                $arr[$i]['email_id'] = $str;
                $arr[$i]['name'] = 'smtp.' . $attr[$i] . '.1';
                $arr[$i]['key'] = '1';
            }
            $res2 = EmailKey::insert($arr);
        }
        //2、如果现在的key！=smtp ,以前的key==smtp，并且该条数据的id在key中有数据，删除数据
        if($request->get('key')!='smtp' && EmailKey::where('email_id', $request->get('id'))->first()){
            $res2 = EmailKey::where('email_id',$request->get('id'))->delete();
        }
        if($res1 && $res2){
            return redirect(\URL::action('Background\EmailController@getList'))->withErrors('修改成功');
        }else{
            return back()->withInput()->withErrors('修改失败');
        }
    }
    //endregion

    //region   删除        tang
    public function postDel(Request $request){
        \DB::beginTransaction();
        $email = EmailKey::first();
        $input = $request->get('id');
        $key_Ret = true;
        for($i = 0; $i < count($input); $i++){
            if($input[$i] == $email['email_id']){
                $key_Ret = EmailKey::where('email_id', $email['email_id'])->delete();
            }
            $ret = Email::where('id', $input[$i])->delete();
        }
        if($ret && $key_Ret){
            \DB::commit();
            return redirect(\URL::action('Background\EmailController@getList'))->withErrors('删除成功');
        }else{
            \DB::rollBack();
            return back()->withInput()->withErrors('删除失败');
        }
    }
    //endregion

    //region   发送测试邮件        tang
    public function getTestEmail(){
        return view('background.email.test');
    }
    public function postTestEmail(Request $request){
        $validated = $request->validate([
            'email_id' => 'required|exists:email,id',
            'email' => 'required|email',
            'title' => 'required',
            'content' => 'required',
        ]);
        $email=new \App\Common\Api\Email\Email();
        $email->id=$request->get('email_id');
        $email->toemail=$request->get('email');
        $email->titel=$request->get('title');
        $email->content=$request->get('content');
        $email->send();
        return back()->withInput()->withErrors('发送成功');
    }
    //endregion
}
