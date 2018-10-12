@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $('#form1').initValidform();
        })
    </script>
@include('background.layouts.btnsave')
@endsection
@section('content')
    {{Form::model($data,['url'=>URL::action('Background\AdminController@postEdit'),'id'=>'form1'])}}
        {{Form::hidden('id')}}
        <!--导航栏-->
        <div class="location">
            <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
            <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
            <i class="arrow"></i>
            <a href="{{URL::action('Background\AdminController@getList')}}"><span>管理员管理</span></a>
            <i class="arrow"></i>
            <span>添加管理员</span>
        </div>
        <div class="line10"></div>
        <!--/导航栏-->

        <!--内容-->
        <div id="floatHead" class="content-tab-wrap">
            <div class="content-tab">
                <div class="content-tab-ul-wrap">
                    <ul>
                        <li><a class="selected" href="javascript:;">管理元信息</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <dl>
                <dt>管理角色</dt>
                <dd>
                    <div class="rule-single-select">
                        {{Form::select('admin_role_id',\App\Http\Model\Background\AdminRole::roleList())}}
                    </div>
                </dd>
            </dl>
            <dl>
                <dt>是否锁定</dt>
                <dd>
                    <div class="rule-single-checkbox">
                        {{Form::checkbox('is_lock',true)}}
                    </div>
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>邮箱</dt>
                <dd>
                    {{Form::text('email',null,['class'=>'input normal','datatype'=>'e'])}}
                    <span class="Validform_checktip">*</span>
                </dd>
            </dl>
            <dl>
                <dt>登陆密码</dt>
                <dd>
                    {{Form::password('password',['class'=>'input normal'])}}
                    <span class="Validform_checktip">*</span>
                </dd>
            </dl>
            <dl>
                <dt>确认密码</dt>
                <dd>
                    {{Form::password('password_confirmation',['class'=>'input normal'])}}
                    <span class="Validform_checktip">*</span>
                </dd>
            </dl>
            <dl>
                <dt>姓名</dt>
                <dd>
                    {{Form::text('username',null,['class'=>'input normal','datatype'=>'*'])}}
                    <span class="Validform_checktip">*</span>
                </dd>
            </dl>
            <dl>
                <dt>电话</dt>
                <dd>
                    {{Form::text('mobile',null,['class'=>'input normal','datatype'=>''])}}
                    <span class="Validform_checktip">*</span>
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