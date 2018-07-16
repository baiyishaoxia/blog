<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <?php echo $__env->make('background.layouts.btnsave', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<script type="text/javascript">
		$('.channel_category_id').change(function () {
			var the_form=$(this).parents('form').eq(0);
			the_form.attr('method','get');
			the_form.submit();
		})
	</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo e(Form::open()); ?>


   <!--导航栏-->
	<div class="location">
		<a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
		<a href="<?php echo e(URL::action('Admin\IndexController@info')); ?>" class="home"><i></i><span>首页</span></a>
		<i class="arrow"></i>
		<span>图片列表</span>
	</div>
	<!--/导航栏-->

	<!--工具栏-->
	<div id="floatHead" class="toolbar-wrap">
		<div class="toolbar">
			<div class="box-wrap">
				<a class="menu-btn"></a>
				<div class="l-list">
					<ul class="icon-list">
						<li><a class="add" href="<?php echo e(URL::action('Admin\ImagesContentController@getCreate')); ?>"><i></i><span>新增</span></a></li>
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
						<li><a href="<?php echo e(URL::action('Admin\ImagesContentController@postDel')); ?>" class="del btndel" ><i></i><span>删除</span></a></li>
					</ul>
				</div>
				<div class="r-list">
					<div class="rule-single-select">
						<?php echo e(Form::select('ImgClass_Id',\App\Http\Model\Background\ImagesClass::tree(2),Request::get('ImgClass_Id'))); ?>

					</div>
					<?php echo e(Form::text('keywords',Request::get('keywords',''),['class'=>'keyword'])); ?>

					<a class="btn-search" href="javascript:void (0)">查询</a>
				</div>
			</div>
		</div>
	</div>
	<!--/工具栏-->

	<!--列表-->
	<div class="table-container">
		<div class="photo-list">
			<ul>
				<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>
						<div align="center">
                                <span class="checkall" style="vertical-align:middle;">
									<?php echo e(Form::checkbox('id[]',$val['Id'],null)); ?>

                                </span>
						</div>
						<div class="img-box" onclick="setFocusImg(this);">
							<img src="<?php echo e(Storage::url($val->Icon)); ?>" bigsrc="<?php echo e(Storage::url($val->path)); ?>">
						</div>
						<a href="javascript:void(0)" onclick="delCate(<?php echo e($val->Id); ?>)">删除</a>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	</div>
	<!--/列表-->
	<span class="page_total">共<?php echo e($data->total()); ?>条记录</span>
	<?php echo e($data->links()); ?>

    <?php echo e(Form::close()); ?>

<script>
    function delCate(id){
        layer.confirm('您确定要删除这个照片吗？', {
            btn: ['确定','取消']
        }, function(){
            $.get('<?php echo e(URL::action('Admin\ImagesContentController@del')); ?>',{'_method':'get','_token':"<?php echo e(csrf_token()); ?>",'id':id},function(data){
                if(data.status == 0){
                    layer.msg(data.msg, {icon: 6});
                    location.reload();
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('background.layouts.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>