@extends('background.layouts.main')
@section('css')
    {{Html::style('admin/tmp/css/style_y.css')}}
@endsection
@section('js')
    @include('background.layouts.btnsave')
    @include('admin.article_tmp.create_tmp_js.to_activity_js')
    <script type="text/javascript">
        //初始化上传控件
        $(function () {
            $('#form1').initValidform();
            $(".upload-album").InitUploader({ btntext: "批量上传", multiple: true, sendurl: "{{URL::action('Background\UploadController@postImg')}}", swf: "{{asset('background/script/webuploader/uploader.swf')}}"});
            //创建上传附件
            $(".attach-btn").click(function () {
                showAttachDialog();
            });
        });
    </script>
@endsection
@section('content')
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href=""><span>活动管理</span></a>

        <i class="arrow"></i>
        <span>用户参与详情</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

    <!--内容-->
    <div id="floatHead" class="content-tab-wrap">
        <div class="content-tab">
            <div class="content-tab-ul-wrap">
                <ul>
                    <li><a class="selected" href="javascript:;">详情信息</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <dl>
            <dt>属性名称</dt>
            <dd>属性内容</dd>
        </dl>
        @foreach($data as $key => $val)
            <dl>
                <dt>{{$val->tmp_and_field['title']}}</dt>
                <dd>{{$val->value}}</dd>
            </dl>
        @endforeach
    </div>
    <!--/内容-->

@endsection