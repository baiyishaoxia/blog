@extends('layouts.admin')
@section('content')
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">后台管理中心</div>
			<ul>
				<li><a href="#" class="active">首页</a></li>
				<li><a href="#">管理页</a></li>
				<li><a href="{{URL::action('HomeController@index')}}" target="_blank">预览前台</a></li>
			</ul>
		</div>
		<div class="top_right">
			<ul>
				<li>管理员：{{session('user.user_name')}}</li>
				<li><a href="{{url('admin/pass')}}" target="main">修改密码</a></li>
				<li><a href="{{url('admin/quit')}}">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>常用操作</h3>
				<ul class="sub_menu">
					<li><a href="{{Url('admin/category/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加分类</a></li>
					<li><a href="{{Url('admin/category')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>分类列表</a></li>
					<li><a href="{{Url('admin/article/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加文章</a></li>
					<li><a href="{{Url('admin/article')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>文章列表</a></li>
					<li><a href="{{url('admin/links')}}" target="main"><i class="fa fa-fw fa-chain"></i>友情链接</a></li>
					<li><a href="{{URL::action('Admin\ImagesListController@index')}}" target="main"><i class="fa fa-fw fa-list-alt"></i>图片分类</a></li>
					<li><a href="{{URL::action('Admin\ImagesContentController@index')}}" target="main"><i class="fa fa-fw fa-image"></i>图片列表</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-cog"></i>系统设置</h3>
				<ul class="sub_menu">
					<li><a href="{{URL::action('Background\FileController@getList')}}" target="main"><i class="fa fa-fw fa-cubes"></i>上传配置</a></li>
					<li><a href="{{URL::action('Admin\IndexController@info')}}" target="main"><i class="fa fa-fw fa-database"></i>备份还原</a></li>
					<li><a href="{{URL::action('Admin\ToolsController@getIndex')}}" target="main"><i class="fa fa-home fa-google"></i>工具类</a></li>
					<li><a href="{{URL::action('Admin\ToolsController@getRecycleList')}}" target="main"><i class="fa fa-home fa-refresh"></i><span>进入回收站</span></a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-thumb-tack"></i>工具导航</h3>
				<ul class="sub_menu">
					<li><a href="http://www.yeahzan.com/fa/facss.html" target="main"><i class="fa fa-fw fa-font"></i>图标调用</a></li>
					<li><a href="http://hemin.cn/jq/cheatsheet.html" target="main"><i class="fa fa-fw fa-chain"></i>Jquery手册</a></li>
					<li><a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-cog"></i>系统工具</h3>
				<ul class="sub_menu">
					<li><a href="{{URL::action('Admin\ReadSystemController@getElement')}}" target="main"><i class="fa fa-fw fa-tags"></i>其它组件</a></li>
					<li><a href="{{URL::action('Admin\ReadSystemController@getList')}}" target="main"><i class="fa fa-home fa-file-text"></i>商品页模板</a></li>
					<li><a href="{{URL::action('Admin\ReadSystemController@getTab')}}" target="main"><i class="fa fa-home fa-file-o"></i>商品页模板</a></li>
					<li><a href="{{URL::action('Admin\SystemToolsController@getIndex')}}" target="main"><i class="fa fa-home fa-file"></i>图片裁剪</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
	</div>
	<!--主体部分 结束-->

	<!--底部 开始-->
	<div class="bottom_box">
		CopyRight © 2015. Powered By <a href="http://www.houdunwang.com">http://www.houdunwang.com</a>.
	</div>
	<!--底部 结束-->

@endsection


