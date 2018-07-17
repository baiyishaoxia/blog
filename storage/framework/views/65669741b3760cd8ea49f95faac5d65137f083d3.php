<?php $__env->startSection('content'); ?>

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="<?php echo e(url('admin/info')); ?>">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <?php if($type == 'del'): ?>
        <?php echo e(Form::open(['url'=>URL::action('Admin\ArticleController@getRecycleList')])); ?>

        <?php else: ?>
        <?php echo e(Form::open(['url'=>URL::action('Admin\ArticleController@index')])); ?>

        <?php endif; ?>
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <?php echo e(Form::select('cate_id',\App\Http\Model\Category::tree2(2),Request::get('cate_id'))); ?>

                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><a class="btn-search" href="javascript:void (0)">查询</a></td>
                </tr>
            </table>
        <?php echo e(Form::close()); ?>

    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <?php echo e(Form::open()); ?>

        <div class="result_wrap">
            <div class="result_title">
                <h3>文章列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                   <?php if($type =='del'): ?>
                        <a class="all" href="javascript:;" onclick="checkAll(this);"><i class="fa fa-plus"></i><span>全选</span></a>
                        <a href="<?php echo e(URL::action('Admin\ArticleController@postDel')); ?>" class="del btndel" ><i class="fa fa-recycle"></i><span>彻底删除</span></a>
                        <a href="<?php echo e(URL::action('Admin\ArticleController@postRestore')); ?>" class="del btnsave" ><i class="fa fa-refresh"></i><span>还原</span></a>
                        <a href="<?php echo e(url('admin/article')); ?>" ><i class="fa fa-recycle"></i><span>返回文章列表</span></a>
                   <?php else: ?>
                    <a href="<?php echo e(url('admin/article/create')); ?>"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="<?php echo e(URL::action('Admin\ArticleController@postSave')); ?>"  class="save btnsave"><i class="fa fa-refresh"></i>更新排序</a>
                    <a class="all" href="javascript:;" onclick="checkAll(this);"><i class="fa fa-plus"></i><span>全选</span></a>
                    <a href="<?php echo e(URL::action('Admin\ArticleController@postSoftDel')); ?>" class="del btndel" ><i class="fa fa-recycle"></i>移动到回收站</a>
                    <a href="<?php echo e(URL::action('Admin\ArticleController@getRecycleList')); ?>"><i class="fa fa-refresh"></i>进入回收站</a>
                  <?php endif; ?>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th width="4%">选择</th>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>作者</th>
                        <th>所属类别</th>
                        <th>标签</th>
                        <th>描述</th>
                        <th>缩略图</th>
                        <th>内容</th>
                        <th>更新时间</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th>
							<span class="checkall" style="vertical-align:middle;">
							<?php echo e(Form::checkbox('id[]',$v->art_id,null)); ?>

							</span>
                        </th>
                        <td class="tc">
                            <?php echo e(Form::text('data['.$v->art_id.'][sort]',$v->art_order,['class'=>'sort'])); ?>

                        </td>
                        <td class="tc"><?php echo e($v->art_id); ?></td>
                        <td><a href="#"><?php echo e($v->art_title); ?></a></td>
                        <td><a href="#"><?php echo e($v->art_author); ?></a></td>
                        <td><a href="#"><?php echo e(\App\Http\Model\Category::find($v->cate_id)->cate_name); ?></a></td>
                        <td><?php echo e($v->art_tag); ?></td>
                        <td><?php echo e(str_limit($v->art_discription,18)); ?></td>
                        <td><img src="<?php echo e(Storage::url($v->art_thumb)); ?>" width="100" height="60" align="center"></td>
                        <td><?php echo e(str_limit(strip_tags($v->art_content),18)); ?>  </td>
                        <td><?php echo e(date('Y-m-d',$v->art_time)); ?></td>
                        <td><?php echo e($v->art_view); ?></td>
                        <td>
                            <a href="<?php echo e(url('admin/article')); ?>/<?php echo e($v->art_id); ?>/edit">修改</a>
                            <a href="javascript:void(0)" onclick="delArt(<?php echo e($v->art_id); ?>)">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </table>


                <div class="page_list">
                    <div>
                        <?php echo e($data->appends(['cate_id'=>Request::get('cate_id'),
                                          'keywords'=>Request::get('keywords')
                                         ])->links()); ?>

                        <br /><span class="rows"><?php echo e($count); ?></span>
                    </div>
                </div>

            </div>
        </div>
    <?php echo e(Form::close()); ?>


    <!--搜索结果页面 列表 结束-->
    <script>
        function delArt(art_id) {
            layer.confirm('您确定要删除这篇文章吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('<?php echo e(url('admin/article')); ?>/'+art_id,{'_method':'delete','_token':"<?php echo e(csrf_token()); ?>"},function(data){
                    if(data.status == 0){
                        layer.msg(data.msg, {icon: 6});
                        location.reload();
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
            }, function(){
                layer.msg('主人', {
                    time: 20000, //20s后自动关闭
                    btn: ['谢谢', '我要留在主人身边']
                });
            });
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>