@extends('layouts.admin')
@section('content')
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">后台管理中心</div>
			<ul id="menu-nav">
				<li><a href="javascript:void(0)">{{lang('Home')}}</a></li>
				<li><a href="javascript:void(1)">管理页</a></li>
				<li><a href="{{URL::action('HomeController@index')}}" target="_blank">预览前台</a></li>
				<span><a href="{{URL::action('IndexController@changeSession',['lang'=>'cn'])}}">中</a>/<a href="{{URL::action('IndexController@changeSession',['lang'=>'en'])}}">EN</a></span>
			</ul>
		</div>
		<div class="top_right">
			<ul>
				<li>管理员：{{\App\Http\Model\Admin::info()->username}}【{{\App\Http\Model\Admin::info()->role->role_name}}】</li>
				<li><a href="{{url('admin/pass')}}" target="main">修改密码</a></li>
				<li><a href="{{URL::action('Admin\IndexController@getClear')}}">清理缓存</a></li>
				<li><a href="{{URL::action('Admin\LoginController@quit')}}">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box" id="menu_box">
		<ul>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>常用操作</h3>
				<ul class="sub_menu">
					<li><a href="{{Url('admin/category/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加分类</a></li>
					<li><a href="{{Url('admin/category')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>分类列表</a></li>
					<li><a href="{{Url('admin/article/create')}}" target="main"><i class="fa fa-fw fa-eyedropper"></i>添加文章</a></li>
					<li><a href="{{Url('admin/article')}}" target="main"><i class="fa fa-fw fa-folder-open"></i>文章列表</a></li>
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
					<li><a href="{{URL::action('Admin\MobileApi\MemberController@login')}}" target="main"><i class="fa fa-home fa-check"></i>移动接口</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-adn"></i>VIP专区</h3>
				<ul class="sub_menu">
					<li><a href="{{URL::action('Admin\ToolsContentController@getIndex')}}" target="main"><i class="fa fa-fw fa-table"></i>内容管理</a></li>
					<li><a href="{{URL::action('Background\EmailController@getList')}}" target="main"><i class="fa fa-fw fa-align-right"></i>服务器列表</a></li>
					<li><a href="{{URL::action('Background\EmailController@getTestEmail')}}" target="main"><i class="fa fa-fw fa-send"></i>发送测试邮件</a></li>
					<li><a href="{{URL::action('Background\EmailLogController@getList')}}" target="main"><i class="fa fa-fw fa-comment-o"></i>邮件日志列表</a></li>
					<li><a href="{{URL::action('Background\ConfigController@getConfig')}}" target="main"><i class="fa fa-fw fa-wrench"></i>系统参数设置</a></li>
					<li><a href="{{URL::action('Background\IpBlacklistsController@getList')}}" target="main"><i class="fa fa-fw fa-bell"></i>黑名单管理</a></li>
					<li><a href="{{URL::action('Background\IpWhitelistsController@getList')}}" target="main"><i class="fa fa-fw fa-bell-o"></i>白名单管理</a></li>
					<li><a href="{{URL::action('Background\ConfigController@getIpLimit')}}" target="main"><i class="fa fa-fw fa-bell-slash-o"></i>IP限制设置</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-arrows"></i>管理员管理</h3>
				<ul class="sub_menu">
					<li><a href="{{URL::action('Background\AdminController@getList')}}" target="main"><i class="fa fa-fw fa-list-ol"></i>管理员列表</a></li>
					<li><a href="{{URL::action('Background\AdminRoleController@getList')}}" target="main"><i class="fa fa-fw fa-undo"></i>角色列表</a></li>
					<li><a href="{{URL::action('Background\AdminNavigationController@getList')}}" target="main"><i class="fa fa-fw fa-repeat"></i>权限列表</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-group"></i>活动管理</h3>
				<ul class="sub_menu">
					<li><a href="{{URL::action('Admin\ArticleTmpController@getIndex',['status'=>0])}}" target="main"><i class="fa fa-fw fa-list-ul"></i>活动待审核</a></li>
					<li><a href="{{URL::action('Admin\ArticleTmpController@getIndex',['status'=>1])}}" target="main"><i class="fa fa-fw fa-list-ul"></i>活动已通过</a></li>
					<li><a href="{{URL::action('Admin\ArticleTmpController@getIndex',['status'=>2])}}" target="main"><i class="fa fa-fw fa-list-ul"></i>活动已拒绝</a></li>
					<li><a href="{{URL::action('Admin\ArticleTmpActivityController@getIndex')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>活动参与情况</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-group"></i>短信服务商设置</h3>
				<ul class="sub_menu">
					<li><a href="{{URL::action('Background\SmsController@getList')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>短信服务商管理</a></li>
					<li><a href="{{URL::action('Background\SmsController@postTestSms')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>发送测试短信</a></li>
					<li><a href="{{URL::action('Background\SmsTemplateController@getList')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>短信模板</a></li>
					<li><a href="{{URL::action('Background\SmsLogsController@getList')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>短信日志</a></li>
				</ul>
			</li>
		</ul>
		<ul style="display: none">
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>常用操作</h3>
				<ul class="sub_menu">
					<li><a href="{{Url('admin/category/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加分类</a></li>
					<li><a href="{{Url('admin/category')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>分类列表</a></li>
					<li><a href="{{Url('admin/article/create')}}" target="main"><i class="fa fa-fw fa-eyedropper"></i>添加文章</a></li>
					<li><a href="{{Url('admin/article')}}" target="main"><i class="fa fa-fw fa-folder-open"></i>文章列表</a></li>
					<li><a href="{{url('admin/links')}}" target="main"><i class="fa fa-fw fa-chain"></i>友情链接</a></li>
					<li><a href="{{URL::action('Admin\ImagesListController@index')}}" target="main"><i class="fa fa-fw fa-list-alt"></i>图片分类</a></li>
					<li><a href="{{URL::action('Admin\ImagesContentController@index')}}" target="main"><i class="fa fa-fw fa-image"></i>图片列表</a></li>
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
		CopyRight © {{date('Y',time())}}. Powered By <a href="http://www.houdunwang.com"> 白衣少侠</a>.
	</div>
	<!--底部 结束-->

@endsection


