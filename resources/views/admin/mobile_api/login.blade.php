@extends('layouts.master')
@include('layouts.component.loading')
@section('title', '登录')

@section('content')
{{Form::open()}}
<div class="weui_cells_title"></div>
<div class="weui_cells weui_cells_form">
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">帐号</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="tel" name="account" placeholder="邮箱或手机号"/>
      </div>
  </div>
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="tel" name="password" placeholder="不少于6位"/>
      </div>
  </div>
  <div class="weui_cell weui_vcode">
      <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="varchar" name="valicode" placeholder="请输入验证码"/>
      </div>
      <div class="weui_cell_ft">
          <img src="{{URL::action('Admin\MobileApi\ValidateController@create')}}" class="bk_validate_code"/>
      </div>
  </div>
</div>
<div class="weui_cells_tips"></div>
<div class="weui_btn_area">
  <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onLoginClick();" id="login">登录</a>
</div>
<a href="{{URL::action('Admin\MobileApi\MemberController@register')}}" class="bk_bottom_tips bk_important">没有帐号? 去注册</a>
{{Form::close()}}
@endsection

@section('my-js')
<script type="text/javascript">
  $('#login').click(function () {
          var the_form=$(this).parents('form').eq(0);
          the_form.attr('method','post');
          the_form.submit();
  });
</script>
@endsection
