<!DOCTYPE html>
<html lang="en">
<head>
    <title>后台管理系统</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo e(asset('admin/style/css/ch-ui.admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/style/css/admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/style/font/css/font-awesome.min.css')); ?>">
    <script type="text/javascript" src="<?php echo e(asset('admin/style/js/jquery.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('admin/style/js/btnsave.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('admin/style/js/ch-ui.admin.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('admin/style/js/admin.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('org/layer/layer.js')); ?>"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo e(asset('org/ueditor/ueditor.config.js')); ?>"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo e(asset('org/ueditor/ueditor.all.min.js')); ?>"> </script>
    <script type="text/javascript" charset="utf-8" src="<?php echo e(asset('org/ueditor/lang/zh-cn/zh-cn.js')); ?>"></script>
    <?php echo e(Html::style('admin/style/css/style.css')); ?>

    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->yieldContent('js'); ?>
</head>

<body>
<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('admin.msg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</body>
</html>