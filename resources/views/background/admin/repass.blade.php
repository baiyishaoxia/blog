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
    {{Form::open(['url'=>URL::action('Background\AdminController@postRepass'),'id'=>'form1'])}}
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
                        <li><a class="selected" href="javascript:;">修改管理員密碼</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <dl>
                <dt>登陸賬戶</dt>
                <dd>
                    {{\App\Http\Model\Background\Admin::info()->email}}
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