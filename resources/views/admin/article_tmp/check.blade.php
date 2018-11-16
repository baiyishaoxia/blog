@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
    @include('background.layouts.btnsave')
    <script>
        function lookImg(name, url) {
            $("#lookImg").attr("src", url);
            layer.open({
                type: 1,
                title: false,
                closeBtn: 1,
                shadeClose: true,
                maxmin: true,             //开启最大，最小，还原按钮，只有type为1和2时，才能设置
                area: ['1500px', 'auto'], //宽高
                content: "<img alt=" + name + " title=" + name + " src=" + url + " />"
            });
        }
    </script>
@endsection
@section('content')
    {{Form::model($data,['url'=>URL::action('Admin\ArticleTmpController@postCheck'),'id'=>'form1'])}}
    {{Form::hidden('id')}}
    {{Form::hidden('state',$status)}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <span>活动管理</span>
        <span>审核</span>
    </div>
    <!--/导航栏-->

    <!--内容-->
    <div id="floatHead" class="content-tab-wrap">
        <div class="content-tab">
            <div class="content-tab-ul-wrap">
                <ul>
                    <li><a class="selected" href="javascript:;">活动详情</a></li>
                    <li><a  href="javascript:;">额外字段详情</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <input type="hidden" id="{{$data->id}}">
        <dl>
            <dt>活动标题：</dt>
            <dd>
                {{$data['title']}}
            </dd>
        </dl>
        <dl>
            <dt>活动logo图</dt>
            <dd>
                @foreach(\App\Http\Model\Admin\ArticleTmp::getArticleTmpBannerById($data->id) as $key=>$val)
                    <a href="javascript:lookImg('原图','{{ isset($val['file_url'])?Storage::url($val['file_url']):'' }}')" target="_blank">
                        <img src="{{ isset($val['file_url'])?Storage::url($val['file_url']):'' }}" height="150px" >
                    </a>
                @endforeach
            </dd>
        </dl>
        <dl>
            <dt>活动开始时间-结束时间</dt>
            <dd>
                {{date("Y-m-d H:i", strtotime($data->start_time))}}至{{date("Y-m-d H:i", strtotime($data->end_time))}}
            </dd>
        </dl>
        <dl>
            <dt>活动限制名额</dt>
            <dd>
                {{$data->number}}
            </dd>
        </dl>
        <dl>
            <dt>活动模版</dt>
            <dd>
                <a href="{{ URL::action('Admin\ArticleTmpController@getTemplatePage',['id'=>$data['article_template']]) }}" target="_blank">
                    {{\App\Http\Model\Admin\ArticleTmp::getArticleTemplate($data->article_template)}}
                </a>
            </dd>
        </dl>
        <dl>
            <dt>活动详情</dt>
            <dd>
                <a href="{{ URL::action('Admin\ArticleTmpController@getArticleTmpPage',['id'=>$data['id']]) }}" target="_blank">查看活动详情</a>
            </dd>
        </dl>
        <dl>
            <dt>活动管理员</dt>
            <dd>
                {{$data['tmp_title']}}
            </dd>
        </dl>
        @if($data->status == 0)
            <dl>
                <dt>审批语</dt>
                <dd>
                    {{Form::textarea('comment',null,['class'=>'input normal','id'=>'intro'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
            <dl>
                <dt>是否通过</dt>
                <dd>
                    <div class="rule-single-checkbox">
                        {{Form::checkbox('is_open',true)}}
                    </div>
                    <span class="Validform_checktip">选择通过，不选择不通过</span>
                </dd>
            </dl>
            <div class="page-footer">
                <div class="btn-wrap">
                    {{Form::hidden('again_form',Session::get('refuse_form'))}}
                    {{Form::submit('提交保存',['class'=>'btn','id'=>'subm'])}}
                    {{Form::button('返回上一页',['class'=>'btn yellow','onclick'=>'javascript:history.back(-1);'])}}
                </div>
            </div>
        @else
            <dl>
                <dt>审批语</dt>
                <dd>
                    {{Form::textarea('comment',null,['class'=>'input normal','id'=>'intro'])}}
                    <span class="Validform_checktip"></span>
                </dd>
            </dl>
        @endif
    </div>
    <!--活动额外字段-->
    <div class="tab-content" style="display: none">
        <div class="table-container">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ltable">
                <thead>
                <tr>
                    {{--<th width="4%">选择</th>--}}
                    <th width="10%" align="center">标题</th>
                    <th width="10%" align="center">是否必填</th>
                    <th width="10%" align="center">字段类型</th>
                    <th width="10%" align="center">字段内容</th>
                    <th width="10%" align="center">编辑时间</th>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\Http\Model\Admin\ArticleTmpExtraField::getArticleTmpExtraField($data->id) as $key=>$val)
                    <tr>
                        <td align="center">{{$val->title}}</td>
                        <td align="center">{{$val->is_required?"必填":"非必填"}}</td>
                        <td align="center">{{$val['field_type']}}</td>
                        <td align="center">{{$val->child ?:'暂未填写'}}</td>
                        <td align="center">{{$val->updated_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/内容-->
    {{Form::close()}}
@endsection