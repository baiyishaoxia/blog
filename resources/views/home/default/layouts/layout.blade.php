<!DOCTYPE html>
<html lang="zh-CN" style="transform: none;">
<head>
    <link rel="shortcut icon" href="{{asset('home/default/static/images/logo.ico')}}" type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-transform" /> <!--让页面缓存，每次访问必须到服务器读取-->
    <meta http-equiv="Cache-Control" content="no-siteapp" />   <!--禁止百度、神马、搜狗等搜索引擎转码-->
    <meta name="renderer" content="webkit" />                   <!---极速模式-->
    <meta name="applicable-device" content="pc,mobile" />      <!--自适应的展现合适的效果-->
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')">
    @yield('css')
</head>

<body>
@include('home.default.layouts.msg')
@yield('content')
</body>

{{Html::script('home/default/static/js/jquery.min.js')}}
@yield('js')
</html>