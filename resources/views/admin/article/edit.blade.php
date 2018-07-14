@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                         <p>{{$error}}</p>
                        @endforeach
                    @else
                         <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-plus"></i>新增文章</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-refresh"></i>全部文章</a>
                <a href="jvascrpt:void(0)" onclick="load()"><i class="fa fa-refresh"></i>刷新</a>
                <a href="javascript:history.go(-1);"><i class="fa fa-plus"></i>后退</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/article').'/'.$filed->art_id}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="cate_id">
                                <option value="0">==顶级分类==</option>
                                @foreach($data as $key => $v)
                                  <option value="{{$v->cate_id}}"
                                    @if($v->cate_id == $filed->cate_id)
                                        selected
                                    @endif
                                  >{{str_repeat('-',(5*$v->level))}}{{$v->cate_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title" value="{{$filed->art_title}}">
                            <p>标题可以写30个字</p>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>作者：</th>
                        <td>
                            <input type="text" class="sm" name="art_author" value="{{$filed->art_author}}">
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <input type="text" class="sm"  name="art_thumb" style="width: 460px" value="{{$filed->art_thumb}}">
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
                                        'onUploadSuccess':function (file,data,response) {
                                            $('input[name=art_thumb]').val(data);
                                            $('#art_thumb_img').attr('src','/storage/'+data);
                                        }
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <img src="{{Storage::url($filed->art_thumb)}}" alt="" id="art_thumb_img" class="sm" style="max-width: 350px;max-height: 100px" >
                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag" value="{{$filed->art_tag}}">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_discription">{{$filed->art_discription}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>文章内容：</th>
                        <td>
                            <script id="editor" name="art_content" type="text/plain" style="width:590px;height:500px;">
                               {!! $filed->art_content !!}
                            </script>
                            <script type="text/javascript">
                            //实例化编辑器
                            //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                            var ue = UE.getEditor('editor');
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection