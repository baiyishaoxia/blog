@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $('#form1').initValidform();
        })
    </script>
@endsection
@section('content')
    {{Form::model($data,['url'=>URL::action('Background\ConfigController@postIpLimit'),'id'=>'form1'])}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <span>系统设置</span>
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
            <dt>前台应用访问限制</dt>
            <dd>
                <div class="rule-multi-radio">
                    <span>
                        {{Form::radio('sys.ip.home.limit','no',null,['id'=>'home_limit_no'])}}
                        {{Form::label('home_limit_no','无限制')}}
                        {{Form::radio('sys.ip.home.limit','black',null,['id'=>'home_limit_black'])}}
                        {{Form::label('home_limit_black','启用黑名单，禁止黑名单中的IP进行访问，其余允许访问')}}
                        {{Form::radio('sys.ip.home.limit','white',null,['id'=>'home_limit_white'])}}
                        {{Form::label('home_limit_white','启用白名单，允许白名单中的IP进行访问，其余禁止访问')}}
                    </span>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>后台应用访问限制</dt>
            <dd>
                <div class="rule-multi-radio">
                    <span>
                        {{Form::radio('sys.ip.admin.limit','no',null,['id'=>'admin_limit_no'])}}
                        {{Form::label('admin_limit_no','无限制')}}
                        {{Form::radio('sys.ip.admin.limit','black',null,['id'=>'admin_limit_black'])}}
                        {{Form::label('admin_limit_black','启用黑名单，禁止黑名单中的IP进行访问，其余允许访问')}}
                        {{Form::radio('sys.ip.admin.limit','white',null,['id'=>'admin_limit_white'])}}
                        {{Form::label('admin_limit_white','启用白名单，允许白名单中的IP进行访问，其余禁止访问')}}
                    </span>
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