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
        <span>管理员管理</span>
    </div>
    <!--/导航栏-->

    <!--工具栏-->
    <div id="floatHead" class="toolbar-wrap">
        <div class="toolbar">
            <div class="box-wrap">
                <a class="menu-btn"></a>
                <div class="l-list">
                    <ul class="icon-list">
                        <li><a class="add" href="{{URL::action('Background\AdminController@getCreate')}}"><i></i><span>新增</span></a></li>
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                        <li><a href="{{URL::action('Background\AdminController@postDel')}}" class="del btndel" ><i></i><span>删除</span></a></li>
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
                <th align="left">邮箱</th>
                <th align="left" width="10%">姓名</th>
                <th align="left" width="10%">角色</th>
                <th align="left" width="8%">电话</th>
                <th  width="8%">域名</th>
                <th  width="8%">移动端域名</th>
                <th  width="8%">添加时间</th>
                <th width="8%">最后登陸时间</th>
                <th width="8%">登陆次数</th>
                <th width="8%">是否锁定</th>
                <th width="12%">操作</th>
            </tr>
            @foreach($data as $key => $val)
                <tr>
                    <td align="center">
                        <span class="checkall" style="vertical-align:middle;">
                            {{Form::checkbox('id[]',$val['id'])}}
                        </span>
                    </td>
                    <td>{{$val->email}}</td>
                    <td>{{$val->name}}</td>
                    <td>{{$val->role->role_name}}</td>
                    <td>{{$val->mobile}}</td>
                    <td align="center">{{$val->url}}</td>
                    <td align="center">{{$val->app_url}}</td>
                    <td align="center">{{$val->created_at}}</td>
                    <td align="center">{{$val->updated_at}}</td>
                    <td align="center">{{$val->login_count}}</td>
                    <td align="center">{{$val->is_lock?'√':'x'}}</td>
                    <td align="center">
                        <a href="{{URL::action('Background\AdminController@getEdit',['id'=>$val->id])}}">编辑</a>
                        <a target="_blank" href="{{URL::action('Background\AdminController@getAuthorizedLogin',['admin_id'=>Crypt::encrypt($val->id),'suer_id'=>Crypt::encrypt(\App\Http\Model\Admin::info()->id)])}}">授权登录</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <!--/列表-->
    {{Form::close()}}
@endsection