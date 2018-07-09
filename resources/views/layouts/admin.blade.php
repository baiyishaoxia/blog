<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('admin/style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('admin/style/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('admin/style/font/css/font-awesome.min.css')}}">
    <script type="text/javascript" src="{{asset('admin/style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/style/js/btnsave.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/style/js/ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/style/js/admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('org/layer/layer.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.all.min.js')}}"> </script>
    <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    {{Html::style('admin/style/css/style.css')}}
    @yield('css')
    @yield('js')
</head>

<body>

@yield('content')

</body>
</html>