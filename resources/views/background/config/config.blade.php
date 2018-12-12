@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $('#form1').initValidform();
            $(".upload-img").InitUploader({sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('/background/script/webuploader/uploader.swf')}}" });
        })
    </script>
@endsection
@section('content')
    {{Form::model($data,['url'=>URL::action('Background\ConfigController@postConfig'),'id'=>'form1'])}}
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
                    <li><a class="selected" href="javascript:;">系统环境</a></li>
                    <li><a  href="javascript:;">基本信息</a></li>
                    <li><a  href="javascript:;">水印</a></li>
                    <li><a  href="javascript:;">二维码</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <ul class="nlist-1">
            <li>本次登录IP：{{Request::getClientIp()}}</li>
            <li>本次登录计算机名：{{gethostbyaddr($_SERVER[ 'REMOTE_ADDR'])}}</li>
            <li>系统根目录地址：{{$_SERVER[ 'DOCUMENT_ROOT']}}</li>
            <li>服务器IP：{{gethostbyname($_SERVER["SERVER_NAME"])}}</li>
            <li>PHP版本：{{PHP_VERSION}}</li>
            <li>操作系统：{{php_uname()}}</li>
            <li>数据库类型：{{Config::get('database.default')}}</li>
            <li>数据库名称：{{Config::get('database.connections.pgsql.database')}}</li>
        </ul>
    </div>
    <div class="tab-content" style="display: none">
        <dl>
            <dt>主站名称</dt>
            <dd>
                {{Form::text('sys.name',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>是否开启站点</dt>
            <dd>
                <div class="rule-single-checkbox">
                    {{Form::checkbox('sys.is_open',true)}}
                </div>
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>站点关闭提示信息</dt>
            <dd>
                {{Form::text('sys.close_info',null,['class'=>'input normal'])}}
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>数据缓存时间</dt>
            <dd>
                {{Form::text('sys.cache_time',null,['class'=>'input normal','datatype'=>'n'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>后台每页数据展示</dt>
            <dd>
                {{Form::text('sys.paginate',null,['class'=>'input normal','datatype'=>'n'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
    </div>
    <div class="tab-content" style="display: none">
        <dl>
            <dt>是否开启缩略图</dt>
            <dd>
                <div class="rule-single-checkbox">
                    {{Form::checkbox('sys.is_open_thumb',true)}}
                </div>
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>是否开启水印</dt>
            <dd>
                <div class="rule-single-checkbox">
                    {{Form::checkbox('sys.is_open_water',true)}}
                </div>
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>水印图片</dt>
            <dd>
                {{Form::text('sys.water',null,['class' => 'input normal upload-path'])}}
                <div class="upload-box upload-img"></div>
            </dd>
        </dl>
        <dl>
            <dt>水印距离下边距</dt>
            <dd>
                {{Form::text('sys.water_bottom',null,['class'=>'input normal'])}}
            </dd>
        </dl>
        <dl>
            <dt>水印距离右边距</dt>
            <dd>
                {{Form::text('sys.water_left',null,['class'=>'input normal'])}}
                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
    </div>
    <div class="tab-content" style="display: none">
        <dl>
            <dt>是否开启二维码</dt>
            <dd>
                <div class="rule-single-checkbox">
                    {{Form::checkbox('sys.is_open_qrcode',true)}}
                </div>
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>二维码图片</dt>
            <dd>
                {{Form::text('sys.qrcode_img',null,['class' => 'input normal upload-path'])}}
                <div class="upload-box upload-img"></div>
            </dd>
        </dl>
        <dl>
            <dt>二维码边距</dt>
            <dd>
                {{Form::text('sys.qrcode_margin',null,['class'=>'input normal'])}}
            </dd>
        </dl>
        <dl>
            <dt>二维码大小</dt>
            <dd>
                {{Form::text('sys.qrcode_size',null,['class'=>'input normal'])}}
            </dd>
        </dl>
        <dl>
            <dt>二维码前景色-红</dt>
            <dd>
                {{Form::text('sys.color_red',null,['class'=>'input normal'])}}
            </dd>
        </dl>
        <dl>
            <dt>二维码前景色-绿</dt>
            <dd>
                {{Form::text('sys.color_green',null,['class'=>'input normal'])}}
            </dd>
        </dl>
        <dl>
            <dt>二维码前景色-蓝</dt>
            <dd>
                {{Form::text('sys.color_blue_red',null,['class'=>'input normal'])}}
            </dd>
        </dl>
        <dl>
            <dt>二维码背景色-红</dt>
            <dd>
                {{Form::text('sys.background_color_red',null,['class'=>'input normal'])}}
            </dd>
        </dl>
        <dl>
            <dt>二维码背景色-绿</dt>
            <dd>
                {{Form::text('sys.background_color_green',null,['class'=>'input normal'])}}
            </dd>
        </dl>
        <dl>
            <dt>二维码背景色-蓝</dt>
            <dd>
                {{Form::text('sys.background_color_blue',null,['class'=>'input normal'])}}
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