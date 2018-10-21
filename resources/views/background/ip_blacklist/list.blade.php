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
        <span>黑名单管理</span>
    </div>
    <!--/导航栏-->

    <!--工具栏-->
    <div id="floatHead" class="toolbar-wrap">
        <div class="toolbar">
            <div class="box-wrap">
                <a class="menu-btn"></a>
                <div class="l-list">
                    <ul class="icon-list">
                        <li><a class="add" href="{{URL::action('Background\IpBlacklistsController@getCreate')}}"><i></i><span>新增</span></a></li>
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                        <li><a href="{{URL::action('Background\IpBlacklistsController@postDel')}}" class="del btndel" ><i></i><span>删除</span></a></li>
                    </ul>
                </div>
                <div class="r-list">
                    <div class="rule-single-select">
                        {{Form::select('type',array_merge([''=>'所有应用'],\App\Http\Model\Background\IpBlacklists::typeList()),Request::get('type'))}}
                    </div>
                    <div class="rule-single-select">
                        {{Form::select('field',['start_ip'=>'起始ip地址','end_ip'=>'终止ip地址'],Request::get('field'))}}
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
                <th width="4%">选择</th>
                <th align="left">起始ip地址</th>
                <th width="25%" align="left">终止ip地址</th>
                <th width="10%" align="left">类型</th>
                <th width="12%">時間</th>
                <th width="8%">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $val)
                <tr>
                    <td align="center">
						<span class="checkall" style="vertical-align:middle;">
                            {{Form::checkbox('id[]',$val['id'],null)}}
						</span>
                    </td>
                    <td>{{$val->start_ip}}</td>
                    <td>{{$val->end_ip}}</td>
                    <td>{{$val->type}}</td>
                    <td align="center">
                        {{$val->created_at}}
                    </td>
                    <td align="center">
                        <a href="{{URL::action('Background\IpBlacklistsController@getEdit',['id'=>$val->id])}}">编辑</a>
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