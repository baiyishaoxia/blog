<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin\ArticleTmpExtraFieldData;
use App\Http\Model\Background\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleTmpActivityController extends Controller
{
    //region   活动参与情况列表        tang
    public function getIndex(Request $request)
    {
        $keywords = $request->get('keywords');
        $data = ArticleTmpExtraFieldData::orderBy('id', 'desc');
        if ($keywords != '') {
            $data->whereIn('user_id',function ($query) use ($keywords){
                return $query->from('users')->where('name','like','%'.$keywords.'%')->select('id');
            });
        }
        $data =$data->select('user_id','article_tmp_id')->distinct()->paginate(Config::read('sys_paginate'));
        return view('admin.article_activity.list',compact('data'));
    }
    //endregion

    //region   详情信息        tang
    public function getDetail($user_id,$article_tmp_id)
    {
        $data = ArticleTmpExtraFieldData::where('user_id',$user_id)->where('article_tmp_id',$article_tmp_id)->get();
        return view('admin.article_activity.detail',compact('data'));
    }
    //endregion

    //region   删除记录        tang
    public function postDel(Request $request)
    {
        $data = $request->all();
        $count = 0;
        \DB::beginTransaction();
        foreach ($data['id'] as $user_id => $article_tmp_id){
            //清除字段内容表信息
            $res = ArticleTmpExtraFieldData::where('user_id',$user_id)->where('article_tmp_id',$article_tmp_id)->delete();
            if($res){
                $count++;
            }
        }
        if($count == count($data['id'])){
            \DB::commit();
            return redirect(\URL::action('Admin\ArticleTmpActivityController@getIndex'))->withInput()->withErrors('删除成功');
        }else{
            \DB::rollBack();
            return back()->withInput()->withErrors('操作异常,删除失败');
        }
    }
    //endregion
}
