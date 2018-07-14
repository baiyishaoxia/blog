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
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('/background/script/webuploader/uploader.swf')}}" });
            });
            $(".upload-video").each(function () {
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('/background/script/webuploader/uploader.swf')}}" });
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
                content: ['','no'], //iframe的url
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
    {{Form::open(['url'=>URL::action('Admin\ImagesContentController@postCreate'),'id'=>'form1'])}}
        <!--导航栏-->
        <div class="location">
            <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
            <a href="{{URL::action('Admin\IndexController@index')}}" class="home"><i></i><span>首页</span></a>
            <i class="arrow"></i>
            <span>图片列表</span>
        </div>
        <div class="line10"></div>
        <!--/导航栏-->

        <!--内容-->
        <div id="floatHead" class="content-tab-wrap">
            <div class="content-tab">
                <div class="content-tab-ul-wrap">
                    <ul>
                        <li><a class="selected" href="javascript:;">上传图片</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <dl>
                <dt>所属类别</dt>
                <dd>
                    <div class="rule-single-select">
                        {{Form::select('ImgClass_Id',\App\Http\Model\Background\ImagesClass::tree(0))}}
                    </div>
                </dd>
            </dl>
            <dl>
                <dt>选择组图</dt>
                <dd>
                    <div class="upload-box upload-album"></div>
                    <div class="photo-list">
                        <ul>

                        </ul>
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