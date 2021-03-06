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
        <span>工具类管理</span>
    </div>
    <!--/导航栏-->

    <!--工具栏-->
    <div id="floatHead" class="toolbar-wrap">
        <div class="toolbar">
            <div class="box-wrap">
                <a class="menu-btn"></a>
                <div class="l-list">
                    <ul class="icon-list">
                        @if($type=='del')
                            <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                            <li><a href="{{URL::action('Admin\ToolsController@postRecycleDel')}}" class="del btndel" ><i></i><span>彻底删除</span></a></li>
                            <li><a href="{{URL::action('Admin\ToolsController@postRestore')}}" class="del btnsave" ><i></i><span>还原</span></a></li>
                        @else
                            <li><a class="add" href="{{URL::action('Admin\ToolsController@getCreate')}}"><i></i><span>新增</span></a></li>
                            <li><a href="{{URL::action('Admin\ToolsController@postSave')}}"  class="save btnsave" ><i></i><span>保存</span></a></li>
                            <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                            <li><a href="{{URL::action('Admin\ToolsController@postDel')}}" class="del btndel" ><i></i><span>删除</span></a></li>
                            <li><a href="{{URL::action('Admin\ToolsController@postSoftDel')}}" class="del btndel" ><i></i><span>移动到回收站</span></a></li>
                        @endif
                    </ul>
                </div>
                <div class="r-list">
                    <div class="rule-single-select">
                        {{Form::select('id',\App\Http\Model\Admin\ToolsList::tree(2),Request::get('id'))}}
                    </div>
                    <div class="rule-single-select">
                        {{Form::select('field',\App\Http\Model\Admin\ToolsList::tree(3),Request::get('field'))}}
                    </div>
                    {{Form::text('keywords',Request::get('keywords',''),['class'=>'keyword'])}}
                    <a class="btn-search" href="javascript:void (0)">查询</a>
                </div>
            </div>
        </div>
    </div>
    <!--/工具栏-->

    <!--列表-->
    <div class="table-container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ltable">
            <tr>
                <th width="3%">选择</th>
                <th width="3%">ID</th>
                <th width="3%">所属ID</th>
                <th>分类名称</th>
                <th>复文本</th>
                <th>是否为系统分类</th>
                <th>文件版本</th>
                <th>适用系统</th>
                <th>文件路径</th>
                <th>文件说明</th>
                <th>属性</th>
                <th>单选</th>
                <th>图片</th>
                <th>文件</th>
                <th>视频</th>
                <th>相册</th>
                <th>内容1</th>
                <th>内容2</th>
                <th>内容3</th>
                <th>排序</th>
                <th >创建日期</th>
                <th >操作</th>
            </tr>
            @foreach($data as $key => $val)
                <tr>
                    <td align="center">
                                <span class="checkall" style="vertical-align:middle;">
									{{Form::checkbox('id[]',$val['id'],null)}}
                                </span>
                    </td>
                    <th>{!! $val['id'] !!}</th>
                    <th>@if($val['parent_id']){{$val['parent_id']}}@else顶级@endif</th>
                    <th>{!! $val['text'] !!}</th>
                    <th>{!! $val['textarea'] !!}</th>
                    <th>@if($val['is_sys'])是@else否@endif</th>
                    <th>{{($val['file_version'])?'有':'未获取'}}</th>
                    <th>{{($val['file_system'])?'有':'未获取'}}</th>
                    <th>{{($val['file_path'])?'有':'未获取'}}</th>
                    <th>{{($val['file_log'])?'有':'未获取'}}</th>
                    <td align="center">
                        <div class="btn-tools">
                            <a title="{{$val['is_top']?"取消置顶":"设置置顶"}}" class="top {{$val['is_top']?"selected":""}}" href="{{URL::action('Admin\ToolsController@getTop',['id'=>$val['id']])}}"></a>
                            <a title="{{$val['is_red']?"取消推荐":"设置推荐"}}" class="red {{$val['is_red']?"selected":""}}" href="{{URL::action('Admin\ToolsController@getRed',['id'=>$val['id']])}}"></a>
                            <a title="{{$val['is_hot']?"取消热门":"设置热门"}}" class="hot {{$val['is_hot']?"selected":""}}" href="{{URL::action('Admin\ToolsController@getHot',['id'=>$val['id']])}}"></a>
                            <a title="{{$val['is_slide']?"取消幻灯片":"设置幻灯片"}}" class="pic {{$val['is_slide']?"selected":""}}" href="{{URL::action('Admin\ToolsController@getSlide',['id'=>$val['id']])}}"></a>
                        </div>
                    </td>
                    <th>{{($val['redio'])?$val['redio']:'未选'}}</th>
                    <th>{{($val['img'])?'有':'无'}}</th>
                    <th>{{($val['files'])?'有':'无'}}</th>
                    <th>{{($val['video'])?'有':'无'}}</th>
                    <th>@if(is_array($val['imgs'])) <?php $count=0; ?>@foreach($val['imgs'] as $k=>$v) <?php $count++; ?> @endforeach {{$count}}张 @else 0张 @endif</th>
                    <th>{{ (strip_tags($val['abstruct']))?str_limit(strip_tags($val['abstruct']),6):'无' }}</th>
                    <th>{{ (strip_tags($val['content']))?str_limit(strip_tags($val['content']),6):'无' }}</th>
                    <th>{{ (strip_tags($val['discription']))?str_limit(strip_tags($val['discription']),6):'无' }}</th>
                    <td align="center">{{Form::text('data['.$val['id'].'][sort]',$val['sort'],['class'=>'sort'])}}</td>
                    <th>{!! $val['created_at'] !!}</th>
                    @if($type=='soft')
                        <td align="center">
                            <a href="{{URL::action('Admin\ToolsController@getCreate',['parent_id'=>$val['id']])}}">添加子栏目</a>
                            <a href="{{URL::action('Admin\ToolsController@getEdit',['id'=>$val['id']])}}">编辑</a>
                        </td>
                    @else
                        <td align="center">无</td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
    <!--/列表-->
    {{Form::close()}}
@endsection