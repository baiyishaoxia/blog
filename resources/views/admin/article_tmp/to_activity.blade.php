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
    {{Form::open(['url'=>URL::action('Admin\ArticleTmpController@postToActivity'),'id'=>'form1'])}}
    {{Form::hidden('id',$id)}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href=""><span>活动管理</span></a>

        <i class="arrow"></i>
        <span>参与活动</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

        <!--内容-->
        <div id="floatHead" class="content-tab-wrap">
            <div class="content-tab">
                <div class="content-tab-ul-wrap">
                    <ul>
                        <li><a class="selected" href="javascript:;">填写信息</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            @if(count($extra_field) > 0)
                <div class="panles" id="tag4">
                    <div class="panels-tt">填写信息<span class="closed">收起</span><span class="open">展开</span></div>
                    <div class="create-form create-cont">
                        @foreach($extra_field as $key=>$val)
                            @if($val['field_type'] == 'text')
                                <dl>
                                    {{Form::hidden('extra_field['.$val['id'].'][id]',$val['id'])}}
                                    <dt><sup>{{$val['is_required']?"*":""}}</sup>{{$val['title']}}：</dt>
                                    <dd >
                                        <input type="text" maxlength="30" name="extra_field[{{$val['id']}}][value]" class="text_in" {{$val['is_required']?"datatype=*":""}} {{$val['is_required']?'nullmsg='.$val['title'].'不能为空':''}}>
                                    </dd>
                                </dl>
                            @endif
                            @if($val['field_type'] == 'textarea')
                                <dl>
                                    {{Form::hidden('extra_field['.$val['id'].'][id]',$val['id'])}}
                                    <dt><sup>{{$val['is_required']?"*":""}}</sup>{{$val['title']}}：</dt>
                                    <dd>
                                        <textarea rows="6" maxlength="500" name="extra_field[{{$val['id']}}][value]" style="width: 415px;" {{$val['is_required']?"datatype=*":""}} {{$val['is_required']?'nullmsg='.$val['title'].'不能为空':''}}></textarea>
                                    </dd>
                                </dl>
                            @endif
                            @if($val['field_type'] == 'radio')
                                <dl>
                                    {{Form::hidden('extra_field['.$val['id'].'][id]',$val['id'])}}
                                    <dt><sup>{{$val['is_required']?"*":""}}</sup>{{$val['title']}}：</dt>
                                    <dd class="dd-item">
                                        <div class="radioBox">
                                            @if($val['child'])
                                                @foreach($val['child'] as $k=>$v)
                                                    <label><input type="radio" name="extra_field[{{$val['id']}}][value]" value="{{$v}}" {{$val['is_required']?"datatype=*":""}} {{$val['is_required']?'nullmsg='.$val['title'].'不能为空':''}}>{{$v}}</label>
                                                @endforeach
                                            @endif
                                        </div>
                                    </dd>
                                </dl>
                            @endif
                            @if($val['field_type'] == 'checkbox')
                                <dl>
                                    {{Form::hidden('extra_field['.$val['id'].'][id]',$val['id'])}}
                                    <dt><sup>{{$val['is_required']?"*":""}}</sup>{{$val['title']}}：</dt>
                                    <dd class="dd-item">
                                        <div class="radioBox">
                                            @if($val['child'])
                                                @foreach($val['child'] as $k=>$v)
                                                    <label><input type="checkbox" name="extra_field[{{$val['id']}}][value][]" value="{{$v}}" {{$val['is_required']?"datatype=*":""}} {{$val['is_required']?'nullmsg='.$val['title'].'不能为空':''}}>{{$v}}</label>
                                                @endforeach
                                            @endif
                                        </div>
                                    </dd>
                                </dl>
                            @endif
                            @if($val['field_type'] == 'upload')
                                <dl>
                                    {{Form::hidden('extra_field['.$val['id'].'][id]',$val['id'])}}
                                    <dt><sup>{{$val['is_required']?"*":""}}</sup>{{$val['title']}}：</dt>
                                    <dd class="dd-item">
                                        <div class="addfile">
                                            <div class="down">
                                                <a href="javascript:void(0);" class="btns fl" id="form_upload">+上传{{$val['title']}}</a>
                                                <label id="file_name" style="display:none;"></label>
                                                {{Form::hidden('extra_field['.$val['id'].'][value][][name]',null,['id'=>'upload_name'])}}
                                                {{Form::hidden('extra_field['.$val['id'].'][value][][url]',null,['id'=>'upload_url'])}}
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!--/内容-->
        <!--工具栏-->
        <div class="page-footer">
            <div class="btn-wrap">
                {{Form::submit('提交保存',['class'=>'btn ajax'])}}
                {{Form::button('返回上一页',['class'=>'btn yellow','onclick'=>'javascript:history.back(-1);'])}}
            </div>
        </div>
        <!--/工具栏-->
    {{Form::close()}}
@endsection