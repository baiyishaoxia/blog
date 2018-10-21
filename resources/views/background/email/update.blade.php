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
    {{Form::model($data,['url'=>URL::action('Background\EmailSmtpController@postEdit'),'id'=>'form1'])}}
    {{Form::hidden('id')}}
            <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href="{{URL::action('Background\AdminController@getList')}}"><span>邮箱管理</span></a>
        <i class="arrow"></i>
        <span>修改邮件服务器</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

    <!--内容-->
    <div id="floatHead" class="content-tab-wrap">
        <div class="content-tab">
            <div class="content-tab-ul-wrap">
                <ul>
                    <li><a class="selected" href="javascript:;">修改邮件服务器</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <dl>
            <dt>SMTP服务器</dt>
            <dd>
                {{Form::text('host',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>是否开启SSL加密传输</dt>
            <dd>
                <div class="rule-single-checkbox">
                    {{Form::checkbox('is_ssl',true)}}
                </div>
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>SMTP端口</dt>
            <dd>
                {{Form::text('port',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>发件人邮箱</dt>
            <dd>
                {{Form::text('from',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>收件人邮箱</dt>
            <dd>
                {{Form::text('username',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>发件人密码</dt>
            <dd>
                {{Form::text('password',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>发件人昵称</dt>
            <dd>
                {{Form::text('nick',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>每日最大发送数量</dt>
            <dd>
                {{Form::text('every_day_send_max',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>是否启用</dt>
            <dd>
                <div class="rule-single-checkbox">
                    {{Form::checkbox('is_lock',true)}}
                </div>
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>排序</dt>
            <dd>
                {{Form::text('sort',null,['class'=>'input normal','datatype'=>'*'])}}
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