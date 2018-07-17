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
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('background/script/webuploader/uploader.swf')}}" });
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
    {{Form::model($data = \App\Http\Model\Admin\ToolsList::find($id),['url'=>URL::action('Admin\ToolsController@postEdit'),'id'=>'form1'])}}
    {{Form::hidden('id')}}
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
                    <li><a href="javascript:;">Laraver百度编辑器</a></li>
                    <li><a href="javascript:;">标准编辑器</a></li>
                    <li><a href="javascript:;">简洁版编辑器</a></li>
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
                    {{Form::select('parent_id',\App\Http\Model\Admin\ToolsList::tree(1))}}
                </div>
            </dd>
        </dl>
        <dl>
            <dt>文本框</dt>
            <dd>
                {{Form::text('text',null,['class'=>'input normal','datatype'=>'*'])}}
                <span class="Validform_checktip">*必填,不可重复</span>
            </dd>
        </dl>
        <dl>
            <dt>复文本框</dt>
            <dd>
                {{Form::textarea('textarea',null,['class'=>'input normal'])}}
            </dd>
        </dl>
        <dl>
            <dt>排序1</dt>
            <dd>
                {{Form::text('sort',99,['class'=>'input small'])}}
                <span class="Validform_checktip">*数字，越小越向前</span>
            </dd>
        </dl>
        <dl>
            <dt>排序2</dt>
            <dd>
                {{Form::number('order', 99, ['class' => 'input normal'])}}
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
        <dl>
            <dt>是否为系统分类</dt>
            <dd>
                <div class="rule-single-checkbox">
                    {{Form::checkbox('is_sys',true)}}
                </div>
                <span class="Validform_checktip"></span>
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
            @if(!is_null($data->file_version))
                <dl><dt>版本号  </dt><dd>{{Form::text('Version', $data->file_version, ['class' => 'input normal'])}}</dd></dl>
                <dl><dt>适应系统</dt><dd>{{Form::text('System', $data->file_system, ['class' => 'input normal'])}}</dd></dl>
                <dl><dt>版本附件</dt><dd>{{Form::text('Path', $data->file_path, ['class' => 'input normal', 'readonly' => 'true'])}}</dd></dl>
                <dl><dt>升级日志</dt><dd>{{Form::textarea('Log', $data->file_log, ['class' => 'input normal'])}}</dd></dl>
            @endif
        </div>
        <dl>
            <dt>推荐类型</dt>
            <dd>
                <div class="rule-multi-checkbox">
                        <span>
                            {{Form::checkbox('is_top',true,null,['id'=>'is_top',($data->is_top)?'selected':''])}}
                            {{Form::label('is_top','置顶')}}
                            {{Form::checkbox('is_red',true,null,['id'=>'is_red',($data->is_red)?'selected':''])}}
                            {{Form::label('item1','推荐')}}
                            {{Form::checkbox('is_hot',true,null,['id'=>'is_hot',($data->is_hot)?'selected':''])}}
                            {{Form::label('item1','热门')}}
                            {{Form::checkbox('is_slide',true,null,['id'=>'is_slide',($data->is_slide)?'selected':''])}}
                            {{Form::label('item1','幻灯片')}}
                        </span>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>单选框</dt>
            <dd>
                <div class="rule-multi-radio">
                <span>
                    {{Form::radio('redio',1,null,['id'=>'people1'])}}
                    {{Form::label('people1','选择1')}}
                    {{Form::radio('redio',2,null,['id'=>'people2'])}}
                    {{Form::label('people2','选择2')}}
                    {{Form::radio('redio',3,null,['id'=>'people3'])}}
                    {{Form::label('people3','选择3')}}
                    {{Form::radio('redio',4,null,['id'=>'people4'])}}
                    {{Form::label('people4','选择4')}}
                </span>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>图片上传</dt>
            <dd>
                {{Form::text('img',null,['class'=>'input normal upload-path'])}}
                <div class="upload-box upload-img"></div>
            </dd>
        </dl>
        <dl>
            <dt>文件上传</dt>
            <dd>
                {{Form::text('files',null,['class'=>'input normal upload-path'])}}
                <div class="upload-box upload-file"></div>
            </dd>
        </dl>
        <dl>
            <dt>视频上传</dt>
            <dd>
                {{Form::text('video',null,['class'=>'input normal upload-path'])}}
                <div class="upload-box upload-video"></div>
            </dd>
        </dl>
    </div>
    <div class="tab-content" style="display: none">
        <dl>
            <dt>批量上传图片</dt>
            <dd>
                <div class="upload-box upload-album"></div>
                <div class="photo-list">
                    <ul>
                        @foreach($imgs as $key => $value)
                            <li>
                                <input type="hidden" class="path" name="photo[{{$key}}][path]" value="{{$value}}">
                                <input type="hidden" class="remark" name="photo[{{$key}}][info]" value="{{$key}}-{{$value}}">
                                <div class="img-box" onclick="setFocusImg(this);">
                                    <img src="{{Storage::url($value)}}" bigsrc="{{Storage::url($value)}}">
                                    <span class="remark"><i>{{$key}}</i></span>
                                </div>
                                <a href="javascript:;" onclick="setRemark(this);">描述</a>
                                <a href="javascript:;" onclick="delImg(this);">删除</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </dd>
        </dl>
    </div>
    <div class="tab-content" style="display: none">
        <!-- 加载Laravel编辑器的容器 -->
        <script id="container" name="abstruct" type="text/plain">{!! $data->abstruct !!}
        </script>

        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            $(function () {
                var ue = UE.getEditor('container');
                ue.ready(function() {
                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                });
            })
        </script>
    </div>
    <div class="tab-content" style="display: none">
        <!-- 加载标准编辑器的容器 -->
        {{Form::textarea('content',null,['id'=>'id_001'])}}
        <script type="text/javascript">
            $(function () {
                var ue = UE.getEditor("id_001");
                ue.ready(function() {
                    ue.execCommand("serverparam", "_token", "'.csrf_token().'");//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                });
            })
        </script>
    </div>
    <div class="tab-content" style="display: none">
        <!-- 加载简洁编辑器的容器 -->
        {{Form::textarea('discription',null,['id'=>'id_002'])}}
        <script type="text/javascript">
            $(function () {
                layui.use("layedit", function(){
                    var layedit = layui.layedit;
                    //构建一个默认的编辑器
                    var index = layedit.build("id_002",{
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

        </div>
    </div>
    <!--/工具栏-->
    {{Form::close()}}
@endsection