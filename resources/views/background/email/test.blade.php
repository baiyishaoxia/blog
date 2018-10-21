@extends('background.layouts.main')
@section('css')
@endsection
@section('content')
    {{Form::open(['url'=>URL::action('Background\EmailController@postTestEmail'),'id'=>'form1'])}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href="{{URL::action('Background\AdminController@getList')}}"><span>邮箱管理</span></a>
        <i class="arrow"></i>
        <span>测试邮件</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

    <!--内容-->
    <div id="floatHead" class="content-tab-wrap">
        <div class="content-tab">
            <div class="content-tab-ul-wrap">
                <ul>
                    <li><a class="selected" href="javascript:;">发送测试邮件</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <dl>
            <dt>短信运营商</dt>
            <dd>
                <div class="rule-single-select">
                    {{Form::select('email_id',\App\Http\Model\Background\Email::getSmtpList())}}
                </div>
            </dd>
        </dl>
        <dl>
            <dt>邮箱号码</dt>
            <dd>
                {{Form::text('email',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>邮件标题</dt>
            <dd>
                {{Form::text('title',"Email Send Test",['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>邮件内容</dt>
            <dd>
                {{Form::textarea('content',"Email Send Content",['class'=>'input normal','datatype'=>'*','id'=>'LAY_demo1'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
    </div>
    <!--/内容-->
    <!--工具栏-->
    <div class="page-footer">
        <div class="btn-wrap">
            {{Form::submit('立即发送',['class'=>'btn'])}}

        </div>
    </div>
    <!--/工具栏-->
    {{Form::close()}}
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $('#form1').initValidform();
            layui.use('layedit', function(){
                var layedit = layui.layedit;
                //构建一个默认的编辑器
                var index = layedit.build('LAY_demo1',{
                    tool: ['Bold','italic','underline','strikeThrough','|','face', 'link', 'unlink', '|', 'left', 'center', 'right']
                });
            });
        })
    </script>
    @include('background.layouts.btnsave')
@endsection