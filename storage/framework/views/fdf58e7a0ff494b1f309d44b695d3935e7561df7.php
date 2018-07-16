<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo e(asset('admin/style/css/ch-ui.admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/style/font/css/font-awesome.min.css')); ?>">
</head>
<body>
	<!--面包屑导航 开始-->
	<div class="crumb_warp">
		<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
		<i class="fa fa-home"></i> <a href="<?php echo e(url('admin/info')); ?>">首页</a> &raquo; 后台基本信息
	</div>
	<!--面包屑导航 结束-->
	
	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="<?php echo e(url('admin/article/create')); ?>"><i class="fa fa-plus"></i>新增文章</a>
                <a href="<?php echo e(url('admin/category/create')); ?>"><i class="fa fa-plus"></i>新增类别</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

	
    <div class="result_wrap">
        <div class="result_title">
            <h3>系统基本信息</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label><?php echo e(PHP_OS); ?></label><span>WINNT</span>
                </li>
                <li>
                    <label>运行环境</label><span><?php echo e($_SERVER['SERVER_SOFTWARE']); ?></span>
                </li>
                <li>
                    <label>静静设计-版本</label><span>v-0.1</span>
                </li>
                <li>
                    <label>上传附件限制</label><span><?php echo e(get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件"); ?></span>
                </li>
                <li>
                    <label>北京时间</label><span><?php echo e(date('Y年m月d日 H时i分s秒')); ?></span>
                </li>
                <li>
                    <label>服务器域名/IP</label><span><?php echo e($_SERVER['SERVER_NAME']); ?> [<?php echo e($_SERVER['LOCAL_ADDR']); ?>]</span>
                </li>
                <li>
                    <label>Host</label><span><?php echo e($_SERVER['LOCAL_ADDR']); ?></span>
                </li>
            </ul>
        </div>
    </div>


    <div class="result_wrap">
        <div class="result_title">
            <h3>使用帮助</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>官方交流网站：</label><span><a href="#">http://bbs.houdunwang.com</a></span>
                </li>
                <li>
                    <label>官方交流QQ群：</label><span><a href="#"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png"></a></span>
                </li>
            </ul>
        </div>
    </div>
	<!--结果集列表组件 结束-->

</body>
</html>