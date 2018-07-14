@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
    @include('background.layouts.btnsave')
    <script type="text/javascript">
        //初始化上传控件
        $(function () {
            $('#form1').initValidform();
            $(".upload-img").each(function () {
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('/background/script/webuploader/uploader.swf')}}" });

            });
            $(".upload-file").each(function () {
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postFile')}}", swf: "{{asset('background/script/webuploader/uploader.swf')}}"},1);
            });
            $(".upload-video").each(function () {
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('/background/script/webuploader/uploader.swf')}}" });
            });
            $(".upload-album").InitUploader({ btntext: "批量上传", multiple: true, sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('/background/script/webuploader/uploader.swf')}}" });
            //创建上传附件
            $(".attach-btn").click(function () {
                showAttachDialog();
            });
        });
        //初始化附件窗口

        var attachDialog;
        function showAttachDialog(obj) {
            var objNum = arguments.length;
            var index=layer.open({
                type: 2,
                title: '上传附件',
                area: '500px',
                content: ['{{URL::action('Background\ToolsController@getFile')}}','no'], //iframe的url
                btn: ['确定', '取消'], //按钮
                btn1:function(){
                    btn1function();
                }
            });
            if (objNum == 1) {
                attachDialog = obj;
            }
        }
        //删除附件节点
        function delAttachNode(obj) {
            $(obj).parent().remove();
        }


    </script>
@endsection
@section('content')
    {{Form::open(['url'=>'','id'=>'form1'])}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href=""><span>栏目管理</span></a>

        <i class="arrow"></i>
        <span>添加栏目</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

    <!--内容-->
    <div id="floatHead" class="content-tab-wrap">
        <div class="content-tab">
            <div class="content-tab-ul-wrap">
                <ul>
                    <li><a class="selected" href="javascript:;">基本选项框</a></li>
                    <li><a href="#tab2">扩展选项框1</a></li>
                    <li><a href="javascript:;">扩展选项框2</a></li>
                    <li><a href="javascript:;">其他扩展</a></li>
                    <li><a href="javascript:;">SEO选项</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <dl>
            <dt>类别框</dt>
            <dd>
                <div class="rule-single-select">
                    {{Form::select('Class_Id', ['0'=>'类别1','1'=>'类别2'], null, ['class' => 'input normal'])}}
                </div>
            </dd>
        </dl>
        <dl>
            <dt>文本框</dt>
            <dd>
                {{Form::text('Title',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*必填,不可重复</span>
            </dd>
        </dl>
        <dl>
            <dt>图片框</dt>
            <dd>
                {{Form::text('Icon',null,['class'=>'input normal upload-path'])}}
                <div class="upload-box upload-img"></div>
            </dd>
        </dl>
        <dl>
            <dt>复文本框</dt>
            <dd>
                {{Form::textarea('Intro',null,['class'=>'input normal'])}}
            </dd>
        </dl>
    </div>

    <div class="tab-content" id="tab2" style="display: none">
        <dl>
            <dt>上传文件</dt>
            <dd>
                <div class="upload-box upload-file"></div>
            </dd>
        </dl>
        <div class="cc">

        </div>
    </div>
    <div class="tab-content" style="display: none">
        <dl>
            <dt>上传文件</dt>
            <dd>
                {{Form::text('file',null,['id' => 'donw_version', 'class'=>'input normal upload-path'])}}
                <div class="upload-box upload-file"></div>
            </dd>
        </dl>

        <dl>
            <dt>批量上传图片</dt>
            <dd>
                <div class="upload-box upload-album"></div>
                <div class="photo-list">
                    <ul>

                    </ul>
                </div>
            </dd>
        </dl>
    </div>
    <div class="tab-content" style="display: none">
        <!-- 加载编辑器的容器 -->
        <script id="container" name="Content" type="text/plain">
        </script>

        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            $(function () {
                var ue = UE.getEditor('container')
                ue.ready(function() {
                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                });
            })
        </script>
    </div>
    <div class="tab-content" style="display: none">
        <dl>
            <dt>SEO标题</dt>
            <dd>
                {{Form::text('SeoTitle',null,['class'=>'input normal'])}}
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>SEO关键词</dt>
            <dd>
                {{Form::text('Keywords',null,['class'=>'input normal'])}}
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>SEO描述</dt>
            <dd>
                {{Form::textarea('Description',null,['class'=>'input normal'])}}
                <span class="Validform_checktip"></span>
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