@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $(".upload-img").each(function () {
                $(this).InitUploader({sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('/background/script/webuploader/uploader.swf')}}" });
            });
        })
    </script>
    @include('background.layouts.btnsave')
@endsection
@section('content')
    {{Form::open(['url'=>URL::action('Admin\ImagesListController@postCreate'),'id'=>'form1'])}}
        <!--导航栏-->
        <div class="location">
            <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
            <a href="{{URL::action('Admin\IndexController@index')}}" class="home"><i></i><span>首页</span></a>
            <i class="arrow"></i>
            <a href="{{URL::action('Admin\ImagesListController@index')}}"><span>相册类别</span></a>
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
                        <li><a class="selected" href="javascript:;">基本信息</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <dl>
                <dt>所属类别</dt>
                <dd>
                    <div class="rule-single-select">
                        {{Form::select('Pid',\App\Http\Model\Background\ImagesClass::tree(1),$Pid)}}
                    </div>
                </dd>
            </dl>
            <dl>
                <dt>类别名称</dt>
                <dd>
                    {{Form::text('Name',null,['class'=>'input normal','datatype'=>'*'])}}
                    <span class="Validform_checktip">*</span>
                </dd>
            </dl>
            <dl>
                <dt>分类图片</dt>
                <dd>
                    {{Form::text('Icon',null,['class'=>'input normal upload-path'])}}
                    <div class="upload-box upload-img"></div>
                </dd>
            </dl>
                <dl>
                    <dt>是否为系统分类</dt>
                    <dd>
                        <div class="rule-single-checkbox">
                            {{Form::checkbox('IsDel',true)}}
                        </div>
                        <span class="Validform_checktip"></span>
                    </dd>
                </dl>
            <dl>
                <dt>同级分类排序</dt>
                <dd>
                    {{Form::text('Sort',99,['class'=>'input small','datatype'=>'*'])}}
                    <span class="Validform_checktip">*数字，越小越向前</span>
                </dd>
            </dl>

            <dl>
                <dt>分类简介</dt>
                <dd>
                    {{Form::textarea('Intro',null,['class'=>'input normal'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>

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
        <div class="tab-content" style="display: none">
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