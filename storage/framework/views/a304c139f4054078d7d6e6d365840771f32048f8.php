<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script type="text/javascript">
        $(function () {
            $('#form1').initValidform();
            $('#add_parameter').click(function () {
                var rand=parseInt(Math.random()*1000);
                var html='<tr>' +
                        '<td></td>' +
                        '<td><input type="text" name="data['+rand+'][name]" class="input normal" datatype="*"></td>' +
                        '<td><input type="text" name="data['+rand+'][key]" class="input normal" datatype="*"></td>' +
                        '<td><a href="javscript:void(0)" class="remove">删除</a></td>' +
                        '</tr>';
                $('#html').append(html);
                $('#form1').initValidform();
            });
            $('#html').on('click','.remove',function () {
                $(this).parents('tr').eq(0).remove();
            })
        })
    </script>
    <?php echo $__env->make('background.layouts.btnsave', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo e(Form::open(['url'=>URL::action('Background\FileKeyController@postSetKey'),'id'=>'form1'])); ?>

    <?php echo e(Form::hidden('file_id',$file_id)); ?>

    <!--导航栏-->
    <div class="location">
        <a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
        <a href="<?php echo e(URL::action('Admin\IndexController@info')); ?>" class="home"><i></i><span>首页</span></a>
        <i class="arrow"></i>
        <a href="<?php echo e(URL::action('Background\FileController@getList')); ?>"><span>管理员管理</span></a>
        <i class="arrow"></i>
        <span>添加配置</span>
    </div>
    <div class="line10"></div>
    <!--/导航栏-->

    <!--内容-->
    <div id="floatHead" class="content-tab-wrap">
        <div class="content-tab">
            <div class="content-tab-ul-wrap">
                <ul>
                    <li><a class="selected" href="javascript:;">文件上传设置Key</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="table-container">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ltable">
                <thead>
                <tr>
                    <th width="2%"></th>
                    <th width="30%"  align="left">参数名称（唯一）</th>
                    <th align="left">参数值</th>
                    <th align="left" width="12%">操作</th>
                </tr>
                </thead>
                <tbody  id="html">
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td align="center"></td>
                        <td><?php echo e(Form::text('data['.$key.'][name]',$val['name'],['class'=>'input normal','datatype'=>'*'])); ?><?php if($key<3): ?><?php echo e($title[$key]); ?><?php endif; ?></td>
                        <td><?php echo e(Form::text('data['.$key.'][key]',$val['key'],['class'=>'input normal','datatype'=>'*'])); ?></td>
                        <td align="left">
                            <a href="javscript:void(0)" class="remove">删除</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php echo e(Form::button('添加参数',['class'=>'btn','style'=>'margin-top:20px','id'=>'add_parameter'])); ?>

        </div>
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