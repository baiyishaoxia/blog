<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin\ArticleTmp;
use App\Http\Model\Admin\ArticleTmpExtraField;
use App\Http\Model\Admin\ArticleTmpExtraFieldData;
use App\Http\Model\Background\Config;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleTmpController extends Controller
{
    //region   活动列表        tang
    public function getIndex($status,Request $request)
    {
        $keywords = $request->get('keywords');
        $data = ArticleTmp::orderBy('id', 'desc');
        if($status != ''){
            $data->where('status',$status);
        }
        if ($keywords != '') {
            $data->where('title', 'like', '%' . $keywords . '%');
        }
        $data = $data->paginate(Config::read('sys_paginate'));
        return view('admin.article_tmp.list',compact('data','status'));
    }
    //endregion

    //region   创建        tang
    public function getCreate()
    {
       return view('admin.article_tmp.create');
    }
    public function postCreate(Request $request)
    {
        $data = $request->all();
        $user_info = User::info();
        \DB::beginTransaction();
        //活动banner图
        $banner = ArticleTmp::getArticleTmpBanner($data);
        if(isset($banner['status'])){
            //$res1 失败,抛出异常
            return ['status'=>$banner['status'],'info'=>$banner['info']];
        }else{
            $res1 = $banner['res']?:true;
        }
        //添加活动
        $tmp = new ArticleTmp();
        $tmp->user_id = $user_info['id'];
        $tmp->title = $data['title'];
        $tmp->tmp_title = $data['tmp_title'];
        $tmp->article_template = $data['article_template'];
        $tmp->start_time = $data['start_time'];
        $tmp->end_time = $data['end_time'];
        $tmp->logo = $banner['images_id'];
        $tmp->number  = $data['number'];
        if($data['article_template'] == "4"){
            //表示自定义模板
            $tmp->tmp_detail = isset($data['define_template'])?json_encode($data['define_template']):"";
        }else{
            $tmp->tmp_detail = isset($data['template'])?json_encode($data['template']):"";
        }
        $res = $tmp->save();
        //添加额外字段
        $extra = ArticleTmp::addTmpExtra($data,$tmp);
        $res2 = true;
        if(!empty($extra)){
            $res2 = ArticleTmpExtraField::insert(array_values($extra));
            if(!$res2){
                \DB::rollBack();
                return ['status'=>0,'info'=>'新增字段失败'];
            }
        }
        if($res && $res1 && $res2){
            \DB::commit();
            return ['status'=>200,'info'=>'提交成功','url'=>\URL::action('Admin\ArticleTmpController@getIndex')];
        }else{
            \DB::rollBack();
            return ['status'=>0,'info'=>'系统繁忙,请稍后再试'];
        }
    }
    //endregion

    //region   模板预览        tang
    public function getTemplatePage($id){
        if($id == ''){
            return ['staus'=>0,'info'=>'不存在的模板'];
        }
        if($id == 1){
            return view('admin.article_tmp.static_template.template_one');
        }
        if($id == 2){
            return view('admin.article_tmp.static_template.template_two');
        }
        if($id == 3){
            return view('admin.article_tmp.static_template.template_three');
        }
        if($id == 5){
            return view('admin.article_tmp.static_template.template_four');
        }
        //自定义模板
        if($id == 4){
            return view('admin.article_tmp.static_template.user_define_template');
        }
    }
    //endregion

    //region   审核        tang
    public function getCheck(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $data = ArticleTmp::find($id);
        if(!$data){
            return back()->withErrors('该活动不存在');
        }
        return view('admin.article_tmp.check',compact('data','status'));
    }
    //endregion

    //region   提交审核        tang
    public function postCheck(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $state = $input['state'];
        $is_open = isset($input['is_open'])?$input['is_open']:false;
        $tmp = ArticleTmp::where('id',$id)->lockForUpdate()->first();
        if($is_open){
            //通过
            $tmp->status = 1;
        }else{
            //拒绝
            $tmp->status = 2;
        }
        $tmp->comment = $input['comment'];
        $res = $tmp->save();
        if($res){
            return redirect(\URL::action('Admin\ArticleTmpController@getIndex',['state'=>$state]))->withErrors("修改成功");;
        }else{
            return back()->withInput()->withErrors("修改失败");
        }
    }
    //endregion

    //region   删除额外字段        tang
    public function isAbleDelField(Request $request){
        $tmp_id= $request->get('tmp_id');
        $field_id = $request->get('field_id');
        if($tmp_id == ''){
            return ['status'=>0,'info'=>'活动不能为空'];
        }
        if($field_id == ''){
            return ['status'=>0,'info'=>'字段不能为空'];
        }
        //查询改字段是否存在数据
        $info = ArticleTmpExtraFieldData::where('article_tmp_id',$tmp_id)->where('article_tmp_extra_field_id',$field_id)->first();
        if($info){
            return ['status'=>0,'info'=>'该字段下已存在活动信息,无法删除'];
        }
        $res = ArticleTmpExtraField::where('user_id',User::info()['id'])->where('article_tmp_id',$tmp_id)->where('id',$field_id)->delete();
        if($res){
            return ['status'=>1,'info'=>'删除成功'];
        }else{
            return ['status'=>0,'info'=>'系统繁忙,请稍后再试'];
        }
    }
    //endregion

    //region   编辑        tang
    public function getEdit($id){
        $data = ArticleTmp::where('user_id',User::info()['id'])->where('id',$id)->first();
        if(!$data){
            return back()->withErrors('不存在的活动信息');
        }
        $data->tmp_detail = $data->tmp_detail?json_decode($data->tmp_detail):"";
        $data->extra_field = ArticleTmpExtraField::getArticleTmpExtraField($data->id);
        $data->start_time = \Carbon\Carbon::parse($data['start_time'])->format('Y-m-d');
        $data->end_time = \Carbon\Carbon::parse($data['end_time'])->format('Y-m-d');
        //处理单选和多选的数据
        if($data->extra_field){
            foreach ($data['extra_field'] as $key=>$val){
                if($val['child'] != ''){
                    $data['extra_field'][$key]['child'] = json_decode($val['child']);
                }
            }
        }
        return view('admin.article_tmp.edit',compact('data','id'));
    }
    //endregion

    //region   编辑提交        tang
    public function postEdit(Request $request)
    {
        $data = $request->all();
        $user_info = User::info();
        $tmp = ArticleTmp::where('user_id',$user_info['id'])->where('id',$data['id'])->first();
        if(!$tmp){
            return ['status'=>0,'info'=>'活动不存在'];
        }
        if(!isset($data['logo'])){
            return ['status'=>0,'info'=>'请上传活动logo图，最多5张'];
        }
        if($data['start_time'] > $data['end_time']){
            return ['status' => 0, 'info' => '活动开始时间不能大于结束时间'];
        }
        \DB::beginTransaction();
        //活动banner图
        $banner = ArticleTmp::getArticleTmpBanner($data);
        if(isset($banner['status'])){
            //$res1 失败,抛出异常
            return ['status'=>$banner['status'],'info'=>$banner['info']];
        }else{
            $res1 = $banner['res']?:true;
        }
        //修改活动
        $tmp->title = $data['title'];
        $tmp->tmp_title = $data['tmp_title'];
        $tmp->article_template = $data['article_template'];
        $tmp->start_time = $data['start_time'];
        $tmp->end_time = $data['end_time'];
        $tmp->logo = $banner['images_id'];
        $tmp->number  = $data['number'];
        if($data['article_template'] == "4"){
            //表示自定义模板
            $tmp->tmp_detail = isset($data['define_template'])?json_encode($data['define_template']):"";
        }else{
            $tmp->tmp_detail = isset($data['template'])?json_encode($data['template']):"";
        }
        $res = $tmp->save();
        //修改额外字段
        $extra = ArticleTmp::editTmpExtra($data,$tmp);
        $res2 = true;
        if(!empty($extra)){
            $res2 = ArticleTmpExtraField::insert(array_values($extra));
            if(!$res2){
                \DB::rollBack();
                return ['status'=>0,'info'=>'新增字段失败'];
            }
        }
        if($res && $res1 && $res2){
            \DB::commit();
            return ['status'=>200,'info'=>'修改成功','url'=>\URL::action('Admin\ArticleTmpController@getIndex',['status'=>$tmp->status])];
        }else{
            \DB::rollBack();
            return ['status'=>0,'info'=>'系统繁忙,请稍后再试'];
        }
    }
    //endregion

    //审核活动模板详情单页查看   tang
    public function getArticleTmpPage($id){
        $tmp = ArticleTmp::where('id',$id)->first();
        if($tmp['article_template'] == ''){
            return back()->withInput()->withErrors('暂未选择模板');
        }
        $tmp['tmp_detail'] = $tmp['tmp_detail']?json_decode($tmp['tmp_detail']):"";
        $tmp['images'] = ArticleTmp::getArticleTmpBannerById($id);
        if($tmp['article_template'] == 1){
            return view('admin.article_tmp.static_template.template_one',compact('tmp'));
        }
        if($tmp['article_template'] == 2){
            return view('admin.article_tmp.static_template.template_two',compact('tmp'));
        }
        if($tmp['article_template'] == 3){
            return view('admin.article_tmp.static_template.template_three',compact('tmp'));
        }
        if($tmp['article_template'] == 5){
            return view('admin.article_tmp.static_template.template_four',compact('tmp'));
        }
        if($tmp['article_template'] == 4){
            return view('admin.article_tmp.static_template.user_define_template',compact('tmp'));
        }
    }

    //region   参与活动        tang
    public function getToActivity($id)
    {
        //查询用户信息
        $user_info = User::info();
        //查询活动的额外字段
        $extra_field = ArticleTmpExtraField::getArticleTmpExtraField($id);
        if($extra_field){
            foreach($extra_field as $key=>$val){
                if($val['child'] != ''){
                    $extra_field[$key]['child'] = json_decode($val['child']);
                }
                $extra_field[$key]['id'] = $val['id'];
            }
        }
        return view('admin.article_tmp.to_activity',compact('extra_field','user_info','id'));
    }
    //endregion

    //region   参与活动 提交        tang
    public function postToActivity(Request $request)
    {
        $data = $request->all();
        $user_id = User::info()['id'];
        $tmp = ArticleTmp::find($data['id']);
        if(!$tmp){
            return ['status' => 0, 'info' => '该活动暂时无法参与'];
        }
        if($tmp['user_id'] == $user_id){
            return ['status' => 0, 'info' => '无法参与自己发布的活动'];
        }
        if(isset($data['email'])){
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                return ['status'=>0,'info'=>'非法邮箱格式'];
            }
        }
        //判断参与人数
        if($tmp['sign_up_num'] >= $tmp['number']){
            return ['status' => 0, 'info' => '活动参与名额已满'];
        }
        \DB::beginTransaction();
        $activity = ArticleTmpExtraFieldData::UserToActivity($data,$user_id,$tmp);
        if(isset($activity['status'])){
            //失败,抛出异常
            return ['status'=>$activity['status'],'info'=>$activity['info']];
        }
        $res1 = true;
        if(!empty($activity)){
            $res1 = ArticleTmpExtraFieldData::insert(array_values($activity));
            if(!$res1){
                \DB::rollBack();
                return array('status' => 0, 'info' => '保存字段信息失败');
            }
        }
        $res2 = ArticleTmp::where('id',$tmp->id)->increment('sign_up_num');
        if($res1 && $res2){
             \DB::commit();
            return ['status'=>200,'info'=>'参与成功','url'=>\URL::action('Admin\ArticleTmpController@getIndex',['status'=>$tmp->status])];
        }else{
            \DB::rollBack();
            return ['status' => 0, 'info' => '系统繁忙，请稍后再试'];
        }
    }
    //endregion
}
