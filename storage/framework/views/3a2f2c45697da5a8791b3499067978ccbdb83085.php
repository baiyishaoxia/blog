<?php $__env->startSection('css'); ?>
	<?php echo e(Html::style('admin/theme/login/css/crowd.css')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<header>
		<div class="bg">
		<canvas id="display"></canvas>
		<div id="blachole"></div>
		<div class="login_box">
			<h1>白衣少侠</h1>
			<h2>欢迎使用"白衣少侠-Blog"管理平台</h2>
			<div class="form">
				<?php if(session('msg')): ?>
				<p style="color:red"><?php echo e(session('msg')); ?></p>
				<?php endif; ?>
				<form action="" method="post">
					<?php echo e(csrf_field()); ?>

					<ul>
						<li>
						<input type="text" name="user_name" class="text"/>
							<span><i class="fa fa-user"></i></span>
						</li>
						<li>
							<input type="password" name="user_pass" class="text"/>
							<span><i class="fa fa-lock"></i></span>
						</li>
						<li>
							<input type="text" class="code" name="code"/>
							<span><i class="fa fa-check-square-o"></i></span>
							
							
							<?php echo \App\Http\Model\Common\Captcha::code(200,80); ?>

						</li>
						<li>
							<input type="submit" value="立即登陆"/>
						</li>
					</ul>
				</form>
				<p><a href="#">返回首页</a> &copy; <?php echo e(date('Y')); ?> Powered by <a href="http://www.houdunwang.com" target="_blank">http://www.houdunwang.com</a></p>
			</div>
		</div>
	</div>
	</header>
	<script type="text/javascript" src="<?php echo e(asset('admin/theme/login/js/jquery.1.12.4.min.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('admin/theme/login/js/constellation.js')); ?>"></script>
	<script type="text/javascript">
        var url=$('.captcha').attr('src');
        $(".captcha").click(function () {
            url_c = url + "?tmp" + Math.random();
            this.src=url_c;
        })
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>