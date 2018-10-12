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
        <span>后台导航管理</span>
    </div>
    <!--/导航栏-->

    <!--工具栏-->
    <div id="floatHead" class="toolbar-wrap">
        <div class="toolbar">
            <div class="box-wrap">
                <a class="menu-btn"></a>
                <div class="l-list">
                    <ul class="icon-list">
                        <li><a class="add" href="{{URL::action('Background\AdminNavigationController@getCreate')}}"><i></i><span>新增</span></a></li>
                        <li><a href="{{URL::action('Background\AdminNavigationController@postSave')}}"  class="save btnsave" ><i></i><span>保存</span></a></li>
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                        <li><a href="{{URL::action('Background\AdminNavigationController@postDel')}}" class="del btndel" ><i></i><span>删除</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/工具栏-->

    <!--列表-->
    <div class="table-container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ltable">
            <tr>
                <th width="6%">选择</th>
                <th width="8%">图标</th>
                <th align="left">标题</th>
                <th width="8%">显示</th>
                <th width="8%">系统默认</th>
                <th align="left" width="65">排序</th>
                <th width="12%">操作</th>
            </tr>
            @foreach($tree as $key => $val)
                <tr>
                    <td align="center">
                        <span class="checkall" style="vertical-align:middle;">
                            {{Form::checkbox('id[]',$val['id'],null,$val['is_sys']?['disabled'=>'disabled']:[])}}
                        </span>
                    </td>
                    <td></td>
                    <td>{!! $val['title'] !!}@if(!empty($val['child']))【{{$val['child']}}】@endif</td>
                    <td align="center">{{$val['is_show']?'√':'x'}}</td>
                    <td align="center">{{$val['is_sys']?'√':'x'}}</td>
                    <td>{{Form::text('data['.$val['id'].'][sort]',$val['sort'],['class'=>'sort'])}}</td>
                    <td align="center">
                        <a href="{{URL::action('Background\AdminNavigationController@getCreate',['id'=>$val['id']])}}">添加子菜单</a>
                        <a href="{{URL::action('Background\AdminNavigationController@getEdit',['id'=>$val['id']])}}">编辑</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <!--/列表-->
    {{Form::close()}}
@endsection