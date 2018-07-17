<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script type="text/javascript">
        $(function () {
            $('#form1').initValidform();
        })
    </script>
    <?php echo $__env->make('background.layouts.btnsave', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
    <?php echo e(Form::model($data,['url'=>URL::action('Background\FileController@postEdit'),'id'=>'form1'])); ?>

    <?php echo e(Form::hidden('id')); ?>

            <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="<?php echo e(URL::action('Admin\IndexController@info')); ?>" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href="<?php echo e(URL::action('Background\FileController@getList')); ?>"><span>管理员管理</span></a>
        <i class="arrow"></i>
        <span>修改配置</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

    <!--内容-->
    <div id="floatHead" class="content-tab-wrap">
        <div class="content-tab">
            <div class="content-tab-ul-wrap">
                <ul>
                    <li><a class="selected" href="javascript:;">修改文件上传配置</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <dl>
            <dt>名称</dt>
            <dd>
                <?php echo e(Form::text('name',null,['class'=>'input normal','datatype'=>'*'])); ?>

                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>标识码</dt>
            <dd>
                <?php echo e(Form::text('key',null,['class'=>'input normal','datatype'=>'*'])); ?>

                <span class="Validform_checktip">*</span>
            </dd>
        </dl>
        <dl>
            <dt>是否启用</dt>
            <dd>
                <div class="rule-single-checkbox">
                    <?php echo e(Form::checkbox('is_enable',true)); ?>

                </div>
                <span class="Validform_checktip"></span>
            </dd>
        </dl>
    </div>
    <!--/内容-->
    <!--工具栏-->
    <div class="page-footer">
        <div class="btn-wrap">
            <?php echo e(Form::submit('提交保存',['class'=>'btn'])); ?>


        </div>
    </div>
    <!--/工具栏-->
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('background.layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>