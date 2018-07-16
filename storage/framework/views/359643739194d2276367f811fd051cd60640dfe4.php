<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <?php echo $__env->make('background.layouts.btnsave', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo e(Form::open()); ?>

    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="<?php echo e(URL::action('Admin\IndexController@info')); ?>" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <span>图片分类列表</span>
    </div>
    <!--/导航栏-->

    <!--工具栏-->
    <div id="floatHead" class="toolbar-wrap">
        <div class="toolbar">
            <div class="box-wrap">
                <a class="menu-btn"></a>
                <div class="l-list">
                    <ul class="icon-list">
                        <li><a class="add" href="<?php echo e(URL::action('Admin\ImagesListController@getCreate')); ?>"><i></i><span>新增</span></a></li>
                        <li><a href="<?php echo e(URL::action('Admin\ImagesListController@postSave')); ?>"  class="save btnsave" ><i></i><span>保存</span></a></li>
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
                        <li><a href="<?php echo e(URL::action('Admin\ImagesListController@postDel')); ?>" class="del btndel" ><i></i><span>删除</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/工具栏-->

    <!--列表-->
    <div class="table-container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ltable">
            <tr>
                <th width="6%">选择</th>
                <th width="6%">ID</th>
                <th align="left">分类名称</th>
                <th align="left" width="15%">是否为系统分类</th>
                <th align="left" width="65">排序</th>
                <th width="15%">修改日期</th>
                <th width="12%">操作</th>
            </tr>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td align="center">
                                <span class="checkall" style="vertical-align:middle;">
									<?php echo e(Form::checkbox('id[]',$val['Id'],null)); ?>

                                </span>
                    </td>
                    <th><?php echo $val['Id']; ?></th>
                    <td><?php echo $val['Name']; ?></td>
                    <td><?php if($val['IsDel']): ?>是<?php else: ?>否<?php endif; ?></td>
                    <td><?php echo e(Form::text('data['.$val['Id'].'][sort]',$val['Sort'],['class'=>'sort'])); ?></td>
                    <th><?php echo $val['Time']; ?></th>

                    <td align="center">
                        <a href="<?php echo e(URL::action('Admin\ImagesListController@getCreate',['Pid'=>$val['Id']])); ?>">添加子栏目</a>
                        <a href="<?php echo e(URL::action('Admin\ImagesListController@getEdit',['id'=>$val['Id']])); ?>">编辑</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    </div>
    <!--/列表-->
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('background.layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>