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
    {{Form::open(['url'=>URL::action('Background\SmsController@postTestSms'),'id'=>'form1'])}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href="{{URL::action('Admin\IndexController@index')}}"><span>管理员管理</span></a>
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
            <dt>短信运营商</dt>
            <dd>
                <div class="rule-single-select">
                    {{Form::select('type',$sms)}}
                </div>
            </dd>
        </dl>
        <dl>
            <dt>国际地区前缀</dt>
            <dd>
                {{Form::text('prefixe','+86',['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>手机号码</dt>
            <dd>
                {{Form::text('mobile',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>短信内容</dt>
            <dd>
                {{Form::textarea('text',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
    </div>
    <!--/内容-->
    <!--工具栏-->
    <div class="page-footer">
        <div class="btn-wrap">
            {{Form::submit('提交保存',['class'=>'btn'])}}
            {{Form::button('返回上一页',['class'=>'btn yellow','onclick'=>'javascript:history.back(-1);'])}}
        </div>
    </div>
    <!--/工具栏-->
    {{Form::close()}}
@endsection