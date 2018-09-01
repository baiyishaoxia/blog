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
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('background/script/webuploader/uploader.swf')}}" });

            });
            $(".upload-file").each(function () {
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postFile')}}", swf: "{{asset('background/script/webuploader/uploader.swf')}}"},1);
            });
            $(".upload-video").each(function () {
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postVideo')}}", swf: "{{asset('background/script/webuploader/uploader.swf')}}" });
            });
            $(".upload-album").InitUploader({ btntext: "批量上传", multiple: true, sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('background/script/webuploader/uploader.swf')}}" });
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
    {{Form::open(['url'=>URL::action('Admin\ToolsContentController@postCreate'),'id'=>'form1'])}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href=""><span>内容管理</span></a>

        <i class="arrow"></i>
        <span>添加内容</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

        <!--内容-->
        <div id="floatHead" class="content-tab-wrap">
            <div class="content-tab">
                <div class="content-tab-ul-wrap">
                    <ul>
                        <li><a class="selected" href="javascript:;">基本信息</a></li>
                        <li><a href="javascript:;">扩展选项</a></li>
                        <li><a href="javascript:;">详细描述</a></li>
                        <li><a href="javascript:;">SEO选项</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <dl>
                <dt>所属类别</dt>
                <dd>
                    <div class="rule-single-select">
                        {{Form::select('list_id',\App\Http\Model\Admin\ToolsList::tree(2))}}
                    </div>
                </dd>
            </dl>
            <dl>
                <dt>推荐类型</dt>
                <dd>
                    <div class="rule-multi-checkbox">
                        <span>
                            {{Form::checkbox('is_top',true,null,['id'=>'is_top'])}}
                            {{Form::label('is_top','置顶')}}
                            {{Form::checkbox('is_red',true,null,['id'=>'is_red'])}}
                            {{Form::label('item1','推荐')}}
                            {{Form::checkbox('is_hot',true,null,['id'=>'is_hot'])}}
                            {{Form::label('item1','热门')}}
                            {{Form::checkbox('is_slide',true,null,['id'=>'is_slide'])}}
                            {{Form::label('item1','幻灯片')}}
                        </span>
                    </div>
                </dd>
            </dl>
            <dl>
                <dt>调用别名</dt>
                <dd>
                    {{Form::text('call_index',null,['class'=>'input normal','datatype'=>'*'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>内容标题</dt>
                <dd>
                    {{Form::text('title',null,['class'=>'input normal','datatype'=>'*'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>链接</dt>
                <dd>
                    {{Form::text('link',null,['class'=>'input normal','datatype'=>'*'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>上传图片</dt>
                <dd>
                    {{Form::text('img',null,['class'=>'input normal upload-path'])}}
                    <div class="upload-box upload-img"></div>
                </dd>
            </dl>
            <dl>
                <dt>文件上传</dt>
                <dd>
                    {{Form::text('file_url',null,['class'=>'input normal upload-path'])}}
                    <div class="upload-box upload-file"></div>
                </dd>
            </dl>
            <dl>
            	<dt>排序</dt>
            	<dd>
            		{{Form::text('sort',99,['class'=>'input small'])}}
            		<span class="Validform_checktip"></span>
            	</dd>
            </dl>
            <dl>
                <dt>摘要</dt>
                <dd>
                    {{Form::textarea('intro',null,['class'=>'input normal'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>点击次数</dt>
                <dd>
                    {{Form::text('click',0,['class'=>'input small'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>

            <dl>
                <dt>上传附件</dt>
                <dd>
                    <a class="icon-btn add attach-btn"><span>添加附件</span></a>
                    <div id="showAttachList" class="attach-list">
                        <ul>

                        </ul>
                    </div>
                </dd>
            </dl>
        </div>

        <div class="tab-content" style="display: none">
            <dl>
                <dt>前台显示时间</dt>
                <dd>
                    {{Form::text('show_time',null,['class'=>'input d-time normal','datatype'=>'*'])}}
                </dd>
            </dl>
            <dl>
                <dt>简介</dt>
                <dd>
                    {{Form::textarea('abstract',null,['class'=>'input normal'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
        </div>

        <div class="tab-content" style="display: none">
            {{Form::textarea('content',null,['class'=>'wangeditor','style'=>'height:450px','id'=>'editor'])}}
            <script type="text/javascript">
                $(function () {
                    layui.use("layedit", function(){
                        var layedit = layui.layedit;
                        //构建一个默认的编辑器
                        var index = layedit.build("editor",{
                            tool: ["Bold","italic","underline","strikeThrough","|","face", "link", "unlink", "|", "left", "center", "right"]
                        });
                    });
                })
            </script>
        </div>
        <div class="tab-content" style="display: none">
            <dl>
                <dt>SEO标题</dt>
                <dd>
                    {{Form::text('seo_title',null,['class'=>'input normal'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>SEO关键词</dt>
                <dd>
                    {{Form::text('seo_keywords',null,['class'=>'input normal'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>SEO描述</dt>
                <dd>
                    {{Form::textarea('seo_description',null,['class'=>'input normal'])}}
                    <span class="Validform_checktip"></span>
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