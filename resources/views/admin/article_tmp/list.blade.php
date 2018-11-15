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
        <span>活动管理</span>
    </div>
    <!--/导航栏-->

    <!--工具栏-->
    <div id="floatHead" class="toolbar-wrap">
        <div class="toolbar">
            <div class="box-wrap">
                <a class="menu-btn"></a>
                <div class="l-list">
                    <ul class="icon-list">
                        <li><a class="add" href="{{URL::action('Admin\ArticleTmpController@getCreate')}}"><i></i><span>创建</span></a></li>
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                        {{--<li><a href="{{URL::action('Admin\ArticleTmpController@postDel')}}" class="del btndel" ><i></i><span>删除</span></a></li>--}}
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
                <th width="20%">活动名称</th>
                <th align="left">活动logo</th>
                <th align="left">浏览量</th>
                <th align="left">限制人数</th>
                <th align="left">参与人数</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>创建时间</th>
                <th width="8%">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $val)
                <tr>
                    <td align="center">
						<span class="checkall" style="vertical-align:middle;">
                            {{Form::checkbox('id[]',$val['id'],null)}}
						</span>
                    </td>
                    <td align="center">{{$val->title}}</td>
                    <td>@if(count(\App\Http\Model\Admin\ArticleTmp::getArticleTmpBannerById($val->id)))<img src="{{Storage::url(\App\Http\Model\Admin\ArticleTmp::getArticleTmpBannerById($val->id)[0]['file_url'])}}" height="50px">@else 无 @endif</td>
                    <td>{{$val->click}}</td>
                    <td>{{$val->number}}</td>
                    <td>{{$val->sign_up_num}}</td>
                    <td align="center">{{$val->start_time}}</td>
                    <td align="center">{{$val->end_time}}</td>
                    <td align="center">{{$val->created_at}}</td>
                    <td align="center">
                        @if($status ==0)
                            <a  class="thecheck" href="{{URL::action('Admin\ArticleTmpController@getEdit',['id'=>$val->id,'status'=>$status])}}"> 编辑</a>
                            <a  class="thecheck" href="{{URL::action('Admin\ArticleTmpController@getCheck',['id'=>$val->id,'status'=>$status])}}"> 审核</a>
                        @else
                            <a target="_self" class="thecheck" href="{{URL::action('Admin\ArticleTmpController@getCheck',['id'=>$val->id,'status'=>$status])}}"> 查看</a>
                            <a class="thecheck" href="javascript:void(0)" onclick="alert_add('参与活动','{{URL::action('Admin\ArticleTmpController@getToActivity',['id'=>$val->id])}}','900','800')" > 参与活动</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {!! $data->appends(['keywords'=>Request::has('keywords')?Request::get('keywords'):'','status'=>$status])->links() !!}
    <span class="page_total">共{{$data->total()}}条记录</span>
    <!--/列表-->
    {{Form::close()}}
@endsection