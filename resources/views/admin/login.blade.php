@extends('layouts.admin')
@section('css')
	{{Html::style('admin/theme/login/css/crowd.css')}}
@endsection
@section('content')
	<header>
		<div class="bg">
		<canvas id="display"></canvas>
		<div id="blachole"></div>
		<div class="login_box">
			<h1>白衣少侠</h1>
			<h2>欢迎使用"白衣少侠-Blog"管理平台</h2>
			<div class="form">
				@if(session('msg'))
				<p style="color:red">{{session('msg')}}</p>
				@endif
				<form action="" method="post">
					{{csrf_field()}}
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
							{{--<img src="{{url('/admin/code')}}" alt="" onclick="this.src='{{url('/admin/code')}}?'+ Math.random()">--}}
							{{--<img src="{{ url('test/getCreateverify')}}/{{rand(1,999)}}" alt="" onclick="this.src='{{url('/test/getCreateverify')}}/'+ Math.random()">--}}
							{!! \App\Http\Model\Common\Captcha::code(200,80) !!}
						</li>
						<li>
							<input type="submit" value="立即登陆"/>
						</li>
					</ul>
				</form>
				<p><a href="#">返回首页</a> &copy; {{date('Y')}} Powered by <a href="http://www.houdunwang.com" target="_blank">http://www.houdunwang.com</a></p>
			</div>
		</div>
	</div>
	</header>
	<script type="text/javascript" src="{{asset('admin/theme/login/js/jquery.1.12.4.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('admin/theme/login/js/constellation.js')}}"></script>
	<script type="text/javascript">
        var url=$('.captcha').attr('src');
        $(".captcha").click(function () {
            url_c = url + "?tmp" + Math.random();
            this.src=url_c;
        })
	</script>
@endsection