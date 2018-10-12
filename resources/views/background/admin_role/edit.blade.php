@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
    <script type="text/javascript">
        //region 将route权限节点选中   Panjunwei
        $(function () {
            var jsonData='{!! $route_data !!}';
            jsonData=JSON.parse(jsonData);
            $.each(jsonData,function () {
                $("input[value='"+this+"']").attr('checked',true);
            });
            //超级管理员
            var role_type=$("select[name='role_type']").find('option:selected').val();
            if(role_type=='0'){
                $("input[type='checkbox']").each(function () {
                    $(this).attr('disabled','disabled');
                });
            }
        });
        //endregion
        //region 角色类型切换   Panjunwei
        $("select[name='role_type']").change(function () {
            var theValue=$(this).find('option:selected').val();
            switch (theValue){
                case '0':
                    $("input[type='checkbox']").each(function () {
                        $(this).attr('disabled','disabled');
                    });
                    break;
                case '1':
                    $("input[type='checkbox']").each(function () {
                        $(this).removeAttr('disabled');
                    });
                    break;
            }
        })
        //endregion
        //region 全选  Simba
        $('.all').click(function () {
            if($(this).prop('checked')==true){
                $(this).parents('tr').eq(0).find("input[type='checkbox']").prop("checked", true);
            }else {
                $(this).parents('tr').eq(0).find("input[type='checkbox']").prop("checked", false);
            }
        })
        //endregion
        $('#form1').initValidform();
    </script>
    @include('background.layouts.btnsave')
@endsection
@section('content')
    {{Form::model($data,['url'=>URL::action('Background\AdminRoleController@postEdit'),'id'=>'form1'])}}
    {{Form::hidden('id')}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href="{{URL::action('Background\AdminRoleController@getList')}}"><span>角色列表</span></a>
        <i class="arrow"></i>
        <span>角色添加</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

    <!--内容-->
    <div id="floatHead" class="content-tab-wrap">
        <div class="content-tab">
            <div class="content-tab-ul-wrap">
                <ul>
                    <li><a class="selected" href="javascript:;">编辑角色信息</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <dl>
            <dt>角色类型</dt>
            <dd>
                <div class="rule-single-select">
                    {{Form::select('role_type',['1'=>'系统管理员','0'=>'超级管理员'],$data->is_super?'0':'1')}}
                </div>
            </dd>
        </dl>

        <dl>
            <dt>角色名称</dt>
            <dd>
                {{Form::text('role_name',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
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
            <dt>管理权限</dt>
            <dd>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="border-table">
                    <thead>
                    <tr>
                        <th width="24%">导航管理</th>
                        <th >权限分配</th>
                        <th width="12%">全选</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tree as $key => $val)
                        <tr>
                            <td>{!! $val['title'] !!}</td>
                            <td>
                                <span class="cbllist">
                                    @foreach($val['child'] as $k => $v)
                                        {{Form::checkbox('route[]',$v['id'],false,['id'=>'ck'.$k.$key])}}
                                        {{Form::label('ck'.$k.$key,$v['title'])}}
                                    @endforeach
                                </span>
                            </td>
                            <td style="text-align: center">
                                @if(count($val['child'])>0)
                                    {{Form::checkbox('all',1,null,['class'=>'all'])}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
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