@extends('background.layouts.main')
@section('css')
    <style type="text/css">
        #var_box .all{width: 100%;}
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $('#itemAddRountController').click(function () {
                var randIndex=parseInt(Math.random()*10000);
                var html='<tr>' +
                        '<td align="center">' +
                        '   <input type="text" name="node['+randIndex+'][title]" placeholder="名称" class="input nomall" >' +
                        '</td>' +
                        '<td>' +
                        '   <input name="node['+randIndex+'][route_action]" placeholder="请输入控制器路由" class="input all" type="text">' +
                        '</td>' +
                        '<td>' +
                        '   <input name="node['+randIndex+'][parameter]" placeholder="参数JOSN格式" class="input all" type="text">' +
                        '</td>' +
                        '<td align="center">' +
                        '   <input name="node['+randIndex+'][sort]"  class="input small" value="99" type="text">' +
                        '</td>' +
                        '<td align="center">' +
                        '   <a href="javascript:void(0)" class="itemDelRountController">删除</a>' +
                        '</td>' +
                        '</tr>';
                $('#var_box').append(html);
            })
            $('#var_box').on('click','.itemDelRountController',function () {
                $(this).parents('tr').eq(0).remove();
            })
            $('#form1').initValidform();
        })
    </script>
@endsection
@section('content')
    {{Form::model($data,['url'=>URL::action('Background\AdminNavigationController@postEdit'),'id'=>'form1'])}}
    {{Form::hidden('id')}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href=""><span>后台导航管理</span></a>
        <i class="arrow"></i>
        <span>编辑后台导航</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

    <!--内容-->
    <div id="floatHead" class="content-tab-wrap">
        <div class="content-tab">
            <div class="content-tab-ul-wrap">
                <ul>
                    <li><a class="selected" href="javascript:;">基本信息</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <dl>
            <dt>上级导航</dt>
            <dd>
                <div class="rule-single-select">
                    {{Form::select('parent_id',$tree)}}
                </div>
            </dd>
        </dl>
        <dl>
            <dt>排序数字</dt>
            <dd>
                {{Form::text('sort',null,['class'=>'input small','datatype'=>'*'])}}
                <span class="Validform_checktip">*数字，越小越向前</span>
            </dd>
        </dl>
        <dl>
            <dt>是否显示</dt>
            <dd>
                <div class="rule-single-checkbox">
                    {{Form::checkbox('is_show',true)}}
                </div>
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        @if(Config::get('app.debug'))
            <dl>
                <dt>系统默认</dt>
                <dd>
                    <div class="rule-single-checkbox">
                        {{Form::checkbox('is_sys',true)}}
                    </div>
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
        @endif
        <dl>
            <dt>导航名称</dt>
            <dd>
                {{Form::text('title',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>ICO</dt>
            <dd>
                {{Form::text('ico',null,['class'=>'input normal upload-path'])}}
                <div class="upload-box upload-img"></div>
            </dd>
        </dl>
        <dl>
            <dt>权限控制器路由</dt>
            <dd>
                <a id="itemAddRountController" class="icon-btn add"><i></i><span>添加控制器路由</span></a>
                <span class="Validform_checktip">*注意，不添加任何控制器路由则表示该项存在子菜单</span>
            </dd>
        </dl>
        <dl>
            <dt></dt>
            <dd>
                <div class="table-container">
                    <table border="0" cellspacing="0" cellpadding="0" class="border-table" width="100%">
                        <thead>
                        <tr>
                            <th width="10%">名称</th>
                            <th>控制器路由名称</th>
                            <th width="20%">参数JSON格式</th>
                            <th width="10%">排序（值越小越靠前）</th>
                            <th width="10%">操作</th>
                        </tr>
                        </thead>
                        <tbody id="var_box">
                        @foreach($action_route as $key => $val)
                            <tr>
                                <td align="center">
                                    {{Form::hidden('node['.$key.'][id]',$val['id'])}}
                                    {{Form::text('node['.$key.'][title]',$val['title'],['class'=>'input nomall'])}}
                                </td>
                                <td>
                                    {{Form::text('node['.$key.'][route_action]',$val['route_action'],['class'=>'input all'])}}
                                </td>
                                <td>
                                    {{Form::text('node['.$key.'][parameter]',$val['parameter'],['class'=>'input all'])}}
                                </td>
                                <td align="center">
                                    {{Form::text('node['.$key.'][sort]',$val['sort'],['class'=>'input small'])}}
                                </td>
                                <td align="center">
                                    <a class="itemDelRountController" href="javascript:void(0)">删除</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </dd>
        </dl>
    </div>
    <!--/内容-->
    <!--工具栏-->
    <div class="page-footer">
        <div class="btn-wrap">
            {{Form::submit('提交保存',['class'=>'btn'])}}

        </div>
    </div>
    <!--/工具栏-->
    {{Form::close()}}
@endsection