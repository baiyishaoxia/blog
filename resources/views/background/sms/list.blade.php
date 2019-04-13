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
        <a href="{{URL::action('Admin\IndexController@index')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <span>角色管理</span>
    </div>
    <!--/导航栏-->

    <!--工具栏-->
    <div id="floatHead" class="toolbar-wrap">
        <div class="toolbar">
            <div class="box-wrap">
                <a class="menu-btn"></a>
                <div class="l-list">
                    <ul class="icon-list">
                        <li><a class="add" href="{{URL::action('Background\SmsController@getCreate')}}"><i></i><span>新增</span></a></li>
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                        <li><a href="{{URL::action('Background\SmsController@postDel')}}" class="del btndel" ><i></i><span>删除</span></a></li>
                    </ul>
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
                <th width="4%">选择</th>
                <th align="left">名称</th>
                <th width="15%" align="left">是否启用</th>
                <th width="20%" align="left">剩余数量</th>
                <th width="4%" align="left">配置Key</th>
                <th width="12%">時間</th>
                <th width="8%">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $val)
                <tr>
                    <td align="center">
						<span class="checkall" style="vertical-align:middle;">
                            {{Form::checkbox('id[]',$val['id'],null,$val['is_sys']?['disabled'=>'disabled']:[])}}
						</span>
                    </td>
                    <td>{{$val->name}}</td>
                    <td>{{$val->is_enable?'√':'x'}}</td>
                    <td><a href="{{URL::action('Background\SmsController@getSurplusNum',['sms_id'=>$val->id])}}">点击查看</a></td>
                    <td><a href="{{URL::action('Background\SmsKeyController@getSetKey',['sms_id'=>$val->id])}}">配置Key</a></td>
                    <td align="center">
                        {{$val->created_at}}
                    </td>
                    <td align="center">
                        <a href="{{URL::action('Background\SmsController@getEdit',['sms_id'=>$val->id])}}">编辑</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <span class="page_total">共{{$data->total()}}条记录</span>
    {!! $data->appends(['keywords'=>Request::has('keywords')?Request::get('keywords'):''])->links() !!}
    <!--/列表-->
    {{Form::close()}}
@endsection