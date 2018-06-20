@extends('layouts.admin')
@section('content')
    <style>
        table,td{
            border: 1px solid #00a0e9;
            margin:auto;
            font-size: 16px;
        }
        .td1{width: 100px;}
        .td2{width: 220px;}
        input,a{
            float: left;
        }
    </style>
<form action="{{url('test/getCode')}}" method="post">
    {{csrf_field()}}
    <table >
        <tr>
             <td class="td1">用户名：</td>
             <td class="td2"><input type="text" name="username" style="width:220px; height:27px "> </td>
        </tr>
        <tr>
            <td class="td1"> 密码：</td>
            <td class="td2"> <input type="password" name="password" style="width:220px; height:27px "></td>
        </tr>
        <tr>
            <td class="td1">验证码： </td>
            <td class="td2" colspan="2">
                    <input type="text" name="captcha" style="width:110px; height:27px ">
                    <a onclick="javascript:re_captcha();" >
                    <img src="{{ URL('test/getCreateverify')}}/{{rand(1,999)}}" alt="验证码" title="刷新图片" width="110" height="40" id="verify" border="0">
                    </a>
            </td>
        </tr>
        <tr><td colspan="2"><input type="submit" value="提交" style=" height:27px "></td></tr>

    </table>
</form>

<script>
    function re_captcha() {
        $url = "{{ URL('test/getCreateverify') }}";
        $url = $url + "/" + Math.random();
        document.getElementById('verify').src=$url;
    }
</script>

@endsection