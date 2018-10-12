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
                        <li><a class="add" href="{{URL::action('Background\AdminRoleController@getCreate')}}"><i></i><span>新增</span></a></li>
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                        <li><a href="{{URL::action('Background\AdminRoleController@postDel')}}" class="del btndel" ><i></i><span>删除</span></a></li>
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
                <th width="6%">选择</th>
                <th align="left">角色名称</th>
                <th width="8%">类型</th>
                <th width="12%">操作</th>
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
                    <td>{{$val['role_name']}}</td>
                    <td align="center">{{$val['is_super']?'超级管理员':'系统管理员'}}</td>
                    <td align="center">
                        <a href="{{URL::action('Background\AdminRoleController@getEdit',['id'=>$val['id']])}}">编辑</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!--/列表-->
    {{Form::close()}}
@endsection