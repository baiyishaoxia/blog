<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
   {{--适应手机设备--}}
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
  <title>@yield('title')</title>
    {{Html::style('admin/mobile/css/weui.css')}}
    {{Html::style('admin/mobile/css/book.css')}}
    @yield('my-css')
</head>
<body>
<div class="bk_title_bar">
    <img class="bk_back" src="{{asset('admin/mobile/images/back.png')}}" alt="" onclick="history.go(-1)">
    <p class="bk_title_content"> XXX </p>
    <img class="bk_menu" src="{{asset('admin/mobile/images/menu.png')}}" alt="" onclick="onMenuClick();">
</div>



<div class="page">
  @yield('content')
</div>

<!-- tooltips -->
<div class="bk_toptips"><span></span></div>

<div id="global_menu" onclick="onMenuClick();"><div></div></div>

<!--BEGIN actionSheet-->
<div id="actionSheet_wrap">
    <div class="weui_mask_transition" id="mask"></div>
    <div class="weui_actionsheet" id="weui_actionsheet">
        <div class="weui_actionsheet_menu">
            @if(session('member'))
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(1)">主页</div>
            @else
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(0)">登录</div>
            @endif
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(2)">书籍类别</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(3)">购物车</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(4)">我的订单</div>
            @if(session('member'))
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(5)">退出</div>
            @endif
        </div>
        <div class="weui_actionsheet_action">
            <div class="weui_actionsheet_cell" id="actionsheet_cancel">取消</div>
        </div>
    </div>
</div>
</body>
{{Html::script('admin/mobile/js/jquery-1.11.2.min.js')}}
{{Html::script('admin/mobile/js/book.js')}}
<script>
    //点击更换验证码
    $('.bk_validate_code').click(function () {
        $(this).attr('src', '{{URL::action('Admin\MobileApi\ValidateController@create')}}?random=' + Math.random());
    });
</script>
@yield('my-js')
</html>
