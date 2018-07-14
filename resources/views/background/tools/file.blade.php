@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
    @include('background.layouts.btnsave')
    <script type="text/javascript">
        var api = parent.layer.getFrameIndex(window.name); //获取窗口索引
        var attachDialog=window.parent.attachDialog;
        console.log(api);
        //页面加载完成执行
        $(function () {
            //设置按钮及事件
            window.parent.btn1function = function(){
                execAttachHtml();
            };
            //初始化上传控年
            $(".upload-attach").InitUploader({ sendurl: "{{URL::action('Background\UploadController@postFile')}}", swf: "{{asset('/background/script/webuploader/uploader.swf')}}" });
            //远程或者本地上传
            $("input[name='attachType']").click(function () {
                var indexNum = $("input[name='attachType']").index($(this));
                $(".dl-attach-box").hide();
                $(".dl-attach-box").eq(indexNum).show();
            });
            //修改状态，赋值给表单
            if ($(attachDialog).length > 0) {
                var parentObj = $(attachDialog).parent();
                var filePath = parentObj.find(".filepath").val();
                var fileName = parentObj.find(".filename").val();
                var fileSize = parentObj.find(".filesize").val(); //转换为字节
                if (filePath.substring(0, 7).toLowerCase() == "http://") {
                    $(".rule-multi-radio div a").eq(1).trigger("click"); //触发事件
                    $("#txtRemoteTitle").val(fileName);
                    $("#txtRemoteUrl").val(filePath);
                    $(".dl-attach-box").hide();
                    $(".dl-attach-box").eq(1).show();
                } else {
                    $(".rule-multi-radio div a").eq(0).trigger("click"); //触发事件
                    $("#txtFileName").val(fileName);
                    $("#hidFilePath").val(filePath);
                    $("#hidFileSize").val(fileSize);
                    $(".dl-attach-box").hide();
                    $(".dl-attach-box").eq(0).show();
                }
            }
        });

        //创建附件节点
        function execAttachHtml() {
            var currDocument = $(document); //当前文档
            if ($("input[name='attachType']:checked").val() == 0) {
                if ($("#hidFilePath").val() == "" || $("#hidFileSize").val() == "" || $("#txtFileName").val() == "") {
                    parent.layer.msg('没有找到已上传附件，请上传！', {shade: 0.3})
                    return false;
                }
                var fileExt = $("#hidFilePath").val().substring($("#hidFilePath").val().lastIndexOf(".") + 1).toUpperCase();
                var  fileSize=$("#hidFileSize").val();
                var  fileSizeStr=$("#hidFileSize").val();
                /*var fileSize = Math.round($("#hidFileSize").val() / 1024);
                var fileSizeStr = fileSize + "KB";
                if (fileSize >= 1024) {
                    fileSizeStr = ForDight((fileSize / 1024), 1) + "MB";
                }*/
                appendAttachHtml($("#txtFileName").val(), $("#hidFilePath").val(), fileExt, fileSize, fileSizeStr); //插件节点
            } else {
                if ($("#txtRemoteTitle").val() == "" || $("#txtRemoteUrl").val() == "") {
                    parent.layer.msg('远程附件地址或文件名为空！', {shade: 0.3})
                    return false;
                }
                appendAttachHtml($("#txtRemoteTitle").val(), $("#txtRemoteUrl").val(), "", "", "0KB"); //插件节点
            }
        }

        //创建附件节点的HTML
        function appendAttachHtml(fileName, filePath, fileExt, fileSize, fileSizeStr) {
            if ($(attachDialog).length > 0) {
                var parentObj = $(attachDialog).parent();
                parentObj.find(".filename").val(fileName);
                parentObj.find(".filepath").val(filePath);
                parentObj.find(".filesize").val(fileSize);
                parentObj.find(".title").text(fileName);
                parentObj.find(".info .ext").text(fileExt);
                parentObj.find(".info .size").text(fileSizeStr);
                //api.closeAll();
                parent.layer.close(api);
            } else {
                var rand=Math.random();
                var liHtml = '<li>'
                        + '<input class="filename" name="attach['+rand+'][filename]" type="hidden" value="' + fileName + '" />'
                        + '<input class="filepath" name="attach['+rand+'][filepath]" type="hidden" value="' + filePath + '" />'
                        + '<input class="filesize" name="attach['+rand+'][filesize]" type="hidden" value="' + fileSize + '" />'
                        + '<i class="icon"></i>'
                        + '<a href="javascript:;" onclick="delAttachNode(this);" class="del" title="删除附件"></a>'
                        + '<a href="javascript:;" onclick="showAttachDialog(this);" class="edit" title="更新附件"></a>'
                        + '<div class="title">' + fileName + '</div>'
                        + '<div class="info">类型：<span class="ext">' + fileExt + '</span> 大小：<span class="size">' + fileSizeStr + '</span> 下载：<span class="down">0</span>次</div>'
                        + '<div class="btns">下载积分：<input type="text" name="attach['+rand+'][point]" onkeydown="return checkNumber(event);" value="0" /></div>'
                        + '</li>';
                parent.$("#showAttachList").children("ul").append(liHtml);
                parent.layer.close(api);
            }
        }
    </script>
@endsection
@section('content')
    <div class="div-content">
        <dl>
            <dt>附件类型</dt>
            <dd>
                <div class="rule-multi-radio">
                    <input type="radio" name="attachType" value="0" checked="checked" /><label>本地附件</label>
                    {{--<input type="radio" name="attachType" value="1" /><label>远程附件</label>--}}
                </div>
            </dd>
        </dl>
        <div class="dl-attach-box">
            <dl>
                <dt></dt>
                <dd>
                    <input type="hidden" id="hidFilePath" class="upload-path" />
                    <input type="hidden" id="hidFileSize" class="upload-size" />
                    <input type="text" id="txtFileName" class="input txt upload-name" />
                    <div class="upload-box upload-attach"></div>
                </dd>
            </dl>
            <dl>
                <dt></dt>
                <dd>提示：上传文件后，可更改附件名称</dd>
            </dl>
        </div>
        {{--<div class="dl-attach-box" style="display:none;">
            <dl>
                <dt>附件名称</dt>
                <dd><input type="text" id="txtRemoteTitle" class="input txt" /></dd>
            </dl>
            <dl>
                <dt>远程地址</dt>
                <dd><input type="text" id="txtRemoteUrl" class="input txt" /> <span>*以“http://”开头</span></dd>
            </dl>
        </div>--}}
    </div>
@endsection