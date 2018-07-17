<?php $__env->startSection('content'); ?>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">系统工具</a> &raquo; 插件组件
    </div>
    <!--面包屑导航 结束-->


    <div class="result_wrap">
        <table class="add_tab">
            <tr>
                <th width="120">EsayDialog</th>
                <td>
                    <a href="http://www.h-ui.net/easydialog-v2.0/index.html" target="main">
                        http://www.h-ui.net/easydialog-v2.0/index.html 
                    </a>
                </td>
            </tr>
            <tr>
                <th width="120">ArtDialog</th>
                <td>
                    <a href="http://demo.jb51.net/js/2011/artDialog/_doc/labs.html" target="main">
                        http://demo.jb51.net/js/2011/artDialog/_doc/labs.html 
                    </a>
                </td>
            </tr>
            <tr>
                <th width="120">SuperSlide</th>
                <td>
                    <a href="http://www.h-ui.net/easydialog-v2.0/index.html" target="main">
                        http://www.superslide2.com/
                    </a>
                </td>
            </tr>
            <tr>
                <th width="120">表单验证</th>
                <td>
                    <a href="http://validform.rjboy.cn/document.html" target="main">
                        http://validform.rjboy.cn/document.html
                    </a>
                </td>
            </tr>
            <tr>
                <th width="120">日历插件</th>
                <td>
                    <a href="http://laydate.layui.com/" target="main">
                        http://laydate.layui.com/
                    </a>
                </td>
            </tr>
            <tr>
                <th width="120">H-Ui手册</th>
                <td>
                    <a href="http://www.h-ui.net/index.shtml" target="_blank">
                        http://www.h-ui.net/index.shtml
                    </a>
                </td>
            </tr>
        </table>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>