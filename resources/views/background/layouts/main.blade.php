<!DOCTYPE html>
<html>
<head>
    <meta name="renderer" content="webkit|ie-comp|ie-stand" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>管理首页</title>
    {{Html::style('background/skin/style.css')}}
    {{Html::style('background/script/layui/css/layui.css')}}
    {{Html::script('background/script/jquery/jquery-3.1.1.min.js')}}
    {{Html::script('background/script/layer/layer.js')}}
    {{Html::script('background/script/layui/layui.js')}}
    {{Html::script('background/script/validform_v5.3.2/Validform_v5.3.2.js')}}
    {{Html::script('background/script/webuploader/webuploader.min.js')}}
    {{Html::script('background/script/common.js')}}
    {{Html::script('background/js/uploader.js')}}
    {{Html::script('background/js/laymain.js')}}
    @include('UEditor::head')
    @yield('css')
</head>

<body class="mainbody">
@yield('content')
@yield('js')
@include('admin.msg')
<script language="javascript" type="text/javascript">
    //禁用Enter键表单自动提交
    document.onkeydown = function(event) {
        var target, code, tag;
        if (!event) {
            event = window.event; //针对ie浏览器
            target = event.srcElement;
            code = event.keyCode;
            if (code == 13) {
                tag = target.tagName;
                if (tag == "TEXTAREA") { return true; }
                else { return false; }
            }
        }
        else {
            target = event.target; //针对遵循w3c标准的浏览器，如Firefox
            code = event.keyCode;
            if (code == 13) {
                tag = target.tagName;
                if (tag == "INPUT") { return false; }
                else { return true; }
            }
        }
    };
</script>
</body>
</html>
