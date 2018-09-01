@extends('background.layouts.main')
@section('css')
	<link rel="stylesheet" href="{{asset('admin/style/font/css/font-awesome.min.css')}}">
@endsection
@section('js')
	@include('background.layouts.btnsave')
	<script type="text/javascript">
		$('.list_id').change(function () {
			var the_form=$(this).parents('form').eq(0);
			the_form.attr('method','get');
			the_form.submit();
		})
	</script>
@endsection
@section('content')
	{{Form::open()}}
   <!--导航栏-->
   <div class="location">
	   <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
	   <a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
	   <i class="arrow"></i>
	   <span>工具类管理</span>
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
						@if($type == 'del')
						  <li><a href="{{URL::action('Admin\ToolsContentController@postDel')}}" class="del btndel" ><i></i><span>彻底删除</span></a></li>
						  <li><a href="{{URL::action('Admin\ToolsContentController@postRestore')}}" class="del btnsave" ><i></i><span>还原</span></a></li>
					    @else
						  <li><a class="add" href="{{URL::action('Admin\ToolsContentController@getCreate')}}"><i></i><span>新增</span></a></li>
						  <li><a href="{{URL::action('Admin\ToolsContentController@postSave')}}"  class="save btnsave" ><i></i><span>保存</span></a></li>
						  <li><a href="{{URL::action('Admin\ToolsContentController@postSoftDel')}}" class="del btndel" ><i></i><span>移动到回收站</span></a></li>
						  <li><a href="{{URL::action('Admin\ToolsContentController@getRecycleList')}}"><i></i><span>进入回收站</span></a></li>
						@endif
					</ul>
				</div>
				<div class="r-list">
					<div class="rule-single-select">
						{{Form::select('list_id',\App\Http\Model\Admin\ToolsList::tree(2),Request::get('list_id'),['class'=>'list_id'])}}
					</div>
					<div class="rule-single-select">
						{{Form::select('field',['title'=>'标题','top'=>'置顶','red'=>'推荐','hot'=>'热门','slide'=>'幻灯片'],Request::get('field'))}}
					</div>
					{{Form::text('keywords',Request::get('keywords',''),['class'=>'keyword'])}}
					<a class="btn-search" href="javascript:void (0)">查询</a>
				</div>
			</div>
		</div>
	</div>
	<!--/工具栏-->

	<!--列表-->
	<div class="table-container">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="ltable">
			<tr>
				<th width="5%">选择</th>
				<th align="left" width="5%">标题</th>
				<th align="left" width="5%">所属类别</th>
				<th width="12%">关键字</th>
				<th width="12%">链接</th>
				<th width="12%">摘要</th>
				<th width="12%">内容</th>
				<th width="12">排序</th>
				<th width="12%">属性</th>
				<th width="12%">资料下载</th>
				<th width="10%">发布时间</th>
				<th width="5%">操作</th>
			</tr>
			@foreach($data as $key => $val)
				<tr>
					<td align="center">
							<span class="checkall" style="vertical-align:middle;">
							{{Form::checkbox('id[]',$val['id'],null)}}
							</span>
					</td>
					<td>{{$val->title}}</td>
					<td>{{$val->category->text}}</td>
					<th>{{$val->call_index}}</th>
					<th>{{$val->link}}</th>
					<th>@if($val->intro){{$val->intro}} @else 无 @endif</th>
					<th>@if($val->content){{str_limit(strip_tags($val->content),10) }} ... @else 无 @endif</th>
					<td align="center">{{Form::text('data['.$val['id'].'][sort]',$val['sort'],['class'=>'sort'])}}</td>

					<td align="center">
						<div class="btn-tools">
							<a title="{{$val->is_top?"取消置顶":"设置置顶"}}" class="top {{$val->is_top?"selected":""}}" href="{{URL::action('Admin\ToolsContentController@getTop',['id'=>$val->id])}}"></a>
							<a title="{{$val->is_red?"取消推荐":"设置推荐"}}" class="red {{$val->is_red?"selected":""}}" href="{{URL::action('Admin\ToolsContentController@getRed',['id'=>$val->id])}}"></a>
							<a title="{{$val->is_hot?"取消热门":"设置热门"}}" class="hot {{$val->is_hot?"selected":""}}" href="{{URL::action('Admin\ToolsContentController@getHot',['id'=>$val->id])}}"></a>
							<a title="{{$val->is_slide?"取消幻灯片":"设置幻灯片"}}" class="pic {{$val->is_slide?"selected":""}}" href="{{URL::action('Admin\ToolsContentController@getSlide',['id'=>$val->id])}}"></a>
						</div>
					</td>
					@if($attach = \App\Http\Model\Admin\ToolsContentAttache::where('content_id',$val['id'])->first())
					  <td align="center">
						  <a href="{{URL::action('Admin\ToolsContentController@getDownLoad',['id'=>$val['id']])}}">
							  <span class="filename" title="{{$attach['filename']}}">{{$attach['filename']}} <i class="fa fa-download"></i></span>
						  </a>
					  </td>
					@else
					  <td align="center">
						  <a href="javascript:void(0);" class="no_file">
							  <span class="filename" title="{{$attach['filename']}}">{{$attach['filename']}} <i class="fa fa-download"></i></span>
						  </a>
					  </td>
				    @endif
					<td align="center">{{$val->created_at}}</td>
					@if($type == 'soft')
					  <td align="center"><a href="{{URL::action('Admin\ToolsContentController@getEdit',['id'=>$val->id])}}">编辑</a></td>
				    @else
					  <td>软删除了</td>
				    @endif
				</tr>
			@endforeach
		</table>
	</div>
	{{$data->appends(['list_id'=>Request::get('list_id',''),'field'=>Request::get('field',''),'keywords'=>Request::get('keywords','')])->links()}}
	<!--/列表-->
	<span class="page_total">共{{$data->total()}}条记录</span>
    {{Form::close()}}
@endsection