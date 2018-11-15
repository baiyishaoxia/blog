@extends('background.layouts.main')
@section('css')
@endsection
@section('js')
    @include('background.layouts.btnsave')
    <script>
        function alert_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
    </script>
@endsection
@section('content')
    {{Form::open()}}
    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <span>活动参与情况</span>
    </div>
    <!--/导航栏-->

    <!--工具栏-->
    <div id="floatHead" class="toolbar-wrap">
        <div class="toolbar">
            <div class="box-wrap">
                <a class="menu-btn"></a>
                <div class="l-list">
                    <ul class="icon-list">
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                        <li><a href="{{URL::action('Admin\ArticleTmpActivityController@postDel')}}" class="del btndel" ><i></i><span>删除</span></a></li>
                    </ul>
                </div>
                <div class="r-list">
                    <input name="keywords" placeholder="请输入关键词" class="keyword normal" value="{{Request::get('keywords','')}}" type="text">
                    <a class="btn-search" href="javascript:void (0)">查询</a>
                </div>
            </div>
        </div>
    </div>
    <!--/工具栏-->

    <!--列表-->
    <div class="table-container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ltable">
            <thead>
            <tr>
                <th width="4%">选择</th>
                <th>姓名</th>
                <th>活动名称</th>
                <th>活动logo</th>
                <th align="left">活动管理员</th>
                <th>活动开始时间</th>
                <th>活动结束时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $val)
                <tr>
                    <td align="center">
						<span class="checkall" style="vertical-align:middle;">
                            {{Form::checkbox("id[$val->user_id]",$val->article_tmp_id,null)}}
						</span>
                    </td>
                    <td align="center">{{$val->tmp_and_user['name']}}</td>
                    <td align="center">{{$val->tmp_and_article['title']}}</td>
                    <td align="center">@if(count(\App\Http\Model\Admin\ArticleTmp::getArticleTmpBannerById($val->tmp_and_article['id'])))<img src="{{Storage::url(\App\Http\Model\Admin\ArticleTmp::getArticleTmpBannerById($val->tmp_and_article['id'])[0]['file_url'])}}" height="50px">@else 无 @endif</td>
                    <td>{{$val->tmp_and_article['tmp_title']}}</td>
                    <td align="center">{{$val->tmp_and_article['start_time']}}</td>
                    <td align="center">{{$val->tmp_and_article['end_time']}}</td>
                    <td align="center"><a class="thecheck" href="javascript:void(0)" onclick="alert_add('用户参与详情','{{URL::action('Admin\ArticleTmpActivityController@getDetail',['user_id'=>$val->user_id,'article_tmp_id'=>$val->article_tmp_id])}}','900','650')">详情</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {!! $data->appends(['keywords'=>Request::has('keywords')?Request::get('keywords'):''])->links() !!}
    <span class="page_total">共{{count($data)}}条记录</span>
    <!--/列表-->
    {{Form::close()}}
@endsection