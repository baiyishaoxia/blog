<?php $__env->startSection('content'); ?>

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="<?php echo e(url('admin/info')); ?>">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            <?php if(count($errors)>0): ?>
                <div class="mark">
                    <?php if(is_object($errors)): ?>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><?php echo e($error); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p><?php echo e($errors); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="<?php echo e(url('admin/article')); ?>"><i class="fa fa-refresh"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <?php echo e(Form::open(['url'=>url('admin/article/store'),'id'=>'form1'])); ?>

        
            
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>分类：</th>
                    <td>
                        
                        
                        
                        
                        
                        
                        <?php echo e(Form::select('cate_id',\App\Http\Model\Category::tree2(0))); ?>

                    </td>
                </tr>
                <tr>
                    <th>文章标题：</th>
                    <td>
                        <?php echo e(Form::text('art_title',null,['class'=>'lg'])); ?>

                        <p>标题可以写30个字</p>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>作者：</th>
                    <td>
                        <?php echo e(Form::text('art_author',null,['class'=>'sm'])); ?>

                    </td>
                </tr>
                <tr>
                    <th>缩略图：</th>
                    <td>
                        <input type="text" class="sm"  name="art_thumb" style="width: 460px">
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                        <script src="<?php echo e(asset('org/uploadify/jquery.uploadify.js')); ?>" type="text/javascript"></script>
                        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('org/uploadify/uploadify.css')); ?>">
                        <script type="text/javascript">
                            <?php $timestamp = time();?>
                            $(function() {
                                $('#file_upload').uploadify({
                                    'buttonText':'图片上传',
                                    'formData'     : {
                                        'timestamp' : '<?php echo $timestamp;?>',
                                        '_token'     :"<?php echo e(csrf_token()); ?>",
                                    },
                                    'swf'      : '<?php echo e(asset('org/uploadify/uploadify.swf')); ?>',
                                    'uploader' : '<?php echo e(URL::action('Admin\CommonController@upload')); ?>',
                                    'onUploadSuccess':function (file,data,response) {
                                        $('input[name=art_thumb]').val(data);
                                        $('#art_thumb_img').attr('src','/storage/'+data );
                                    }
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <img src="" alt="" id="art_thumb_img" class="sm" style="max-width: 350px;max-height: 100px">
                    </td>
                </tr>
                <tr>
                    <th>关键词：</th>
                    <td>
                        <?php echo e(Form::text('art_tag',null,['class'=>'lg'])); ?>

                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <?php echo e(Form::textarea('art_discription',null)); ?>

                    </td>
                </tr>
                <tr>
                    <th>文章内容：</th>
                    <td>
                        <script id="editor" name="art_content" type="text/plain" style="width:900px;height:300px;"></script>
                        <script type="text/javascript">
                        //实例化编辑器
                        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                        var ue = UE.getEditor('editor');
                        </script>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <?php echo e(Form::submit('提交保存',['class'=>'btn'])); ?>

                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        <?php echo e(Form::close()); ?>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>