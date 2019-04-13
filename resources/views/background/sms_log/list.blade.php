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
                    </ul>
                </div>
                <div class="r-list">
                    <div class="rule-single-select">
                        {{Form::select('field',['mobile'=>'手机号','prefixe'=>'前缀'],Request::get('field'))}}
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
                <th align="left">短信服务商</th>
                <th width="10%" align="left">前缀</th>
                <th width="10%" align="left">手机号</th>
                <th width="25%" align="left">内容</th>
                <th width="12%">時間</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $val)
                <tr>
                    <td align="center">
						<span class="checkall" style="vertical-align:middle;">
                            {{--{{Form::checkbox('id[]',$val['id'],null)}}--}}
						</span>
                    </td>
                    <td>{{$val->sms->name}}</td>
                    <td>{{$val->prefixe}}</td>
                    <td>{{$val->mobile}}</td>
                    <td>{{$val->content}}</td>
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