@extends('layouts.admin')
@section('js')
    <script type="text/javascript">
        function SaveAs5(imgURL)

        {

            var oPop = window.open(imgURL,"","width=1, height=1, top=5000, left=5000");

            for(; oPop.document.readyState != "complete"; )

            { if (oPop.document.readyState == "complete")break; }

            oPop.document.execCommand("SaveAs"); oPop.close();

        }
    </script>
@endsection
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 裁剪工具
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-refresh"></i>系统工具</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        {{Form::open(['url'=>URL::action('Admin\SystemToolsController@create'),'id'=>'form1'])}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th>上传本地图片：</th>
                    <td>
                        <input type="text" class="sm"  name="img" style="width: 460px" value="">
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                        <script src="{{asset('org/uploadify/jquery.uploadify.js')}}" type="text/javascript"></script>
                        <link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}">
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function() {
                                $('#file_upload').uploadify({
                                    'buttonText':'图片上传',
                                    'formData'     : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        '_token'     :"{{csrf_token()}}",
                                    },
                                    'swf'      : '{{asset('org/uploadify/uploadify.swf')}}',
                                    'uploader' : '{{URL::action('Admin\CommonController@upload')}}',
                                    'fileTypeExts': '*.png;*.jpg;*.jpeg;*.gif',
                                    'onUploadSuccess':function (file,data,response) {
                                        $('input[name=img]').val(data);
                                        $('#old_img').attr('src','/storage/'+data );
                                    }
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <th>裁剪为：</th>
                    <td>
                        宽度:{{Form::text('width',null,['class'=>'wd'])}}
                        高度:{{Form::text('height',null,['class'=>'ht'])}}
                        {{Form::button('立即裁剪',['class'=>'cat'])}}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <img src="" alt="" id="old_img" class="sm" style="max-width: 350px;max-height: 100px">
                        <img src="" alt="" id="news_img" class="sm">
                        <input type="hidden" class="sm"  name="news_img" value="">
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        {{Form::submit('提交保存',['class'=>'btn'])}}
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        {{Form::close()}}
    </div>

    <script type="text/javascript">
            $(".cat").click(function () {
                var path = $('#old_img')[0].src;
                var suffix = path.substr(path.lastIndexOf("/storage"));
                if(!$("#old_img").attr("src")){
                    suffix = '/storage/'+$('input[name=img]').val();
                }
                var width =  $('.wd').val();
                var height = $('.ht').val();
                layer.confirm('您确定要裁剪这个照片吗？', {
                    btn: ['确定','取消']
                }, function(){
                    $.get('{{URL::action('Admin\SystemToolsController@imgCat')}}',{'_method':'get','_token':"{{csrf_token()}}",'path':suffix,'width':width,'height':height},function(data){
                        if(data.status == 0){
                            layer.msg(data.msg, {icon: 6});
                            $('input[name=news_img]').val(data.img_url);
                            $('#news_img').attr('src','/storage/'+data.img_url );
                        }else{
                            layer.msg(data.msg, {icon: 5});
                        }
                    });
                });
            });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#fileInput2').uploadify({
                'buttonText': '批量上传',
                'removeCompleted' : true, //上传成功后会自动删除页面上的文件
                'formData': {
                    'timestamp': '<?php echo $timestamp;?>',
                    '_token': "{{csrf_token()}}",
                },
                'swf': '{{asset('org/uploadify/uploadify.swf')}}',
                'cancelImg': '{{asset('org/uploadify/uploadify-cancel.png')}}',//单个取消上传的图片
                'multi': true,  //是否多文件上传
                'auto' : false,//自动上传
                'displayData ': 'speed ',//进度条的显示方式
                'fileSizeLimit': '2MB',//限制文件大小
                'simUploadLimit' :3, //并发上传数据
                'queueSizeLimit' :5, //可上传的文件个数
                'width ': 80,//buttonImg的大小
                'height': 24,
                'rollover ': true,//button是否变换
                'uploader': '{{URL::action('Admin\CommonController@upload')}}',
                'fileTypeExts': '*.png;*.jpg;*.jpeg;*.gif',
                'onUploadSuccess': function (file, data, response) {
                        var board = document.getElementById("divTxt");
                        board.style.display = "";
                        var newInput = document.createElement("input");
                        newInput.type = "text";
                        newInput.size = "45";
                        newInput.name = "myFilePath[]";
                        var obj = board.appendChild(newInput);
                        var br = document.createElement("br");
                        board.appendChild(br);
                        obj.value = data;
                }
            });
        });

 </script>
    <fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0">
        <legend>
            <strong>多文件上传</strong></legend>
        <div>
            <input id="fileInput2" name="fileInput2" type="file" />
            <input type="button" value="确定上传" onclick="javascript:$('#fileInput2').uploadify('upload','*');">
        </div>
        <p></p>
    </fieldset>
    {{Form::open(['url'=>URL::action('Admin\SystemToolsController@create'),'id'=>'form1'])}}
        <div id="divTxt" style="display:none">
                <span style="color:red">
                    <strong>已经上传的图片有：</strong>
                </span><br>
        </div>
        <br>
    {{Form::submit('提交',['class'=>'btn'])}}
    {{Form::close()}}

@endsection