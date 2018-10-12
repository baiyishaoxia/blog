@extends('layouts.admin')
@section('css')
<link href="{{asset('admin/theme/css/index_style.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <!-----背景应用主题 HEADER STAR----->
    <div class="header" id="demo">
         <div class="top_logo"></div>
         <div class="canvaszz"> </div>
         <canvas id="canvas"></canvas>
    </div>
    <!-----HEADER END----->

    <!--用来解决视频右键菜单，用于视频上面的遮罩层 START-->

    <!--用来解决视频右键菜单，用于视频上面的遮罩层 END-->

    <!--音乐 START-->
    <audio controls autoplay class="audio">
        <source src="{{asset('admin/theme/css/Music.mp3')}}" type="audio/mp3">
        <source src="{{asset('admin/theme/css/Music.ogg')}}" type="audio/ogg">
        <source src="{{asset('admin/theme/css/Music.aac')}}" type="audio/mp4">
    </audio>
    <!--音乐 背景应用主题 END-->

	<!--面包屑导航 开始-->
	<div class="crumb_warp">
		<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
		<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 后台基本信息
	</div>
	<!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus">新增文章</i></a>
                <a href="{{url('admin/category/create')}}"><i class="fa fa-plus">新增类别</i></a>
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
                    <label>{{PHP_OS}}</label><span>WINNT</span>
                </li>
                <li>
                    <label>运行环境</label><span>{{$_SERVER['SERVER_SOFTWARE']}}</span>
                </li>
                <li>
                    <label>静静设计-版本</label><span>v-0.1</span>
                </li>
                <li>
                    <label>上传附件限制</label><span>{{get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件"}}</span>
                </li>
                <li>
                    <label>北京时间</label><span>{{date('Y年m月d日 H时i分s秒')}}</span>
                </li>
                <li>
                    <label>服务器域名/IP</label><span>{{$_SERVER['SERVER_NAME']}} [{{$_SERVER['REMOTE_ADDR']}}]</span>
                </li>
                <li>
                    <label>Host</label><span>{{$_SERVER['REMOTE_ADDR']}}</span>
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
    <script>
        //宇宙特效
        "use strict";
        var canvas = document.getElementById('canvas'),
            ctx = canvas.getContext('2d'),
            w = canvas.width = window.innerWidth,
            h = canvas.height = window.innerHeight,
            hue = 217,
            stars = [],
            count = 0,
            maxStars = 1300;//星星数量
        var canvas2 = document.createElement('canvas'),
        ctx2 = canvas2.getContext('2d');
        canvas2.width = 100;
        canvas2.height = 100;
        var half = canvas2.width / 2,
        gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
        gradient2.addColorStop(0.025, '#CCC');
        gradient2.addColorStop(0.1, 'hsl(' + hue + ', 61%, 33%)');
        gradient2.addColorStop(0.25, 'hsl(' + hue + ', 64%, 6%)');
        gradient2.addColorStop(1, 'transparent');
        ctx2.fillStyle = gradient2;
        ctx2.beginPath();
        ctx2.arc(half, half, half, 0, Math.PI * 2);
        ctx2.fill();
        // End cache
        function random(min, max) {
            if (arguments.length < 2) {
                max = min;
                min = 0;
            }
            if (min > max) {
                var hold = max;
                max = min;
                min = hold;
            }
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
        function maxOrbit(x, y) {
            var max = Math.max(x, y),
                diameter = Math.round(Math.sqrt(max * max + max * max));
            return diameter / 2;
            //星星移动范围，值越大范围越小，
        }
        var Star = function() {
            this.orbitRadius = random(maxOrbit(w, h));
            this.radius = random(60, this.orbitRadius) / 8;
            //星星大小
            this.orbitX = w / 2;
            this.orbitY = h / 2;
            this.timePassed = random(0, maxStars);
            this.speed = random(this.orbitRadius) / 50000;
            //星星移动速度
            this.alpha = random(2, 10) / 10;
            count++;
            stars[count] = this;
        }
        Star.prototype.draw = function() {
            var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX,
                y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY,
                twinkle = random(10);
            if (twinkle === 1 && this.alpha > 0) {
                this.alpha -= 0.05;
            } else if (twinkle === 2 && this.alpha < 1) {
                this.alpha += 0.05;
            }
            ctx.globalAlpha = this.alpha;
            ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius);
            this.timePassed += this.speed;
        }
        for (var i = 0; i < maxStars; i++) {
            new Star();
        }
        function animation() {
            ctx.globalCompositeOperation = 'source-over';
            ctx.globalAlpha = 0.5; //尾巴
            ctx.fillStyle = 'hsla(' + hue + ', 64%, 6%, 2)';
            ctx.fillRect(0, 0, w, h)
            ctx.globalCompositeOperation = 'lighter';
            for (var i = 1, l = stars.length; i < l; i++) {
                stars[i].draw();
            };
            window.requestAnimationFrame(animation);
        }
        animation();
    </script>
@endsection