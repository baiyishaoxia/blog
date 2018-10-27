@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
@include('background.layouts.btnsave')
@endsection
@section('content')
{{Form::open()}}
        <!--导航栏-->
<div class="location">
    <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
    <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
    <i class="arrow"></i>
    <span>日志管理</span>
</div>
<!--/导航栏-->

<!--工具栏-->
<div id="floatHead" class="toolbar-wrap">
    <div class="toolbar">
        <div class="box-wrap">
            <a class="menu-btn"></a>
            <div class="l-list">
                <ul class="icon-list">
                </ul>
            </div>
            <div class="r-list">
                <div class="rule-single-select">
                    {{Form::select('field',['email_id'=>'邮件服务器','send_email'=>'发送的邮箱'],Request::get('field'))}}
                </div>
                <input name="keywords" placeholder="请输入关键词" class="keyword normal" value="{{Request::get('keywords','')}}" type="text">
                <a class="btn-search" href="javascript:void (0)">查询</a>
            </div>
        </div>
    </div>
</div>
<!--/工具栏-->

<!--列表-->
<div class="table-container">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ltable">
        <thead>
        <tr>
            <th width="4%"></th>
            <th width="10%" align="left">邮箱服务器</th>
            <th width="10%" align="left">发送的邮箱</th>
            <th width="10%" align="left">发送的标题</th>
            <th width="20%" align="left">发送的内容</th>
            <th width="10%">时间</th>
        </tr>
        </thead>
        <tbody>
        {{--{{dd($data)}}--}}
        @foreach($data as $key => $val)
            <tr>
                <td align="center">
                    <span class="checkall" style="vertical-align:middle;">
                        {{--{{Form::checkbox('id[]',$val['id'],null)}}--}}
                    </span>
                </td>
                <td>{{$val->email->name}}</td>
                <td>{{$val->send_email}}</td>
                <td>{{$val->send_title}}</td>
                <td>{!! $val->send_content !!}</td>
                <td align="center">
                    {{$val->created_at}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<span class="page_total">共{{$data->total()}}条记录</span>
{!! $data->appends([
    'type'=>Request::has('type')?Request::get('type'):'',
    'field'=>Request::has('field')?Request::get('field'):'',
    'keywords'=>Request::has('keywords')?Request::get('keywords'):''])->links()
!!}
        <!--/列表-->
{{Form::close()}}
@endsection